<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.02.16
 * Time: 19:09
 */

namespace common\models;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class Image extends Model
{
    const WEB_PATH = '@frontend/web/';
    const THUMB_100_PREFIX = '-mini100';
    const CACHE_IMAGE_URL = '/images-cache/';
    const IMAGE_URL = '/images/';

     /* @var UploadedFile */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public static function getCachePath(){
        $path = self::WEB_PATH . self::CACHE_IMAGE_URL;
        $path = Yii::getAlias($path);
        return $path;
    }

    public static function getCurrentPath(){
        $year = date('Y');
        $mounth = date('m');
        $dir = Yii::getAlias(self::WEB_PATH);
        $dir = $dir . self::IMAGE_URL . $year . '/' . $mounth . '/';
        return $dir;
    }

    public static function getCurrentUrl(){
        $year = date('Y');
        $mounth = date('m');
        $url = self::IMAGE_URL . $year . '/' . $mounth . '/';
        return $url;
    }

    /**
     * @param $url
     * @return string
     * Получает полный путь по Url файла
     */
    public static function getUrlPath($url){
        $dir = Yii::getAlias(self::WEB_PATH) . $url;
        return $dir;
    }

    /**
     * @param $path
     * @return bool
     * Проверяет, на существование пути, если такого нет, создает путь
     */
    private static function controlPath($path){
        if(!file_exists($path)){
            return mkdir($path);
        }
        return false;
    }


    public static function createThumbnail($image_url){
        $filepath = self::getUrlPath($image_url);
        $filepath = pathinfo($filepath);
        $name = $filepath['filename'];
        $dir = $filepath['dirname'];
        $exten = $filepath['extension'];
        $path = $dir.'/'.$name.'.'.$exten;

        $filenameto = self::getCachePath() . $name .
            self::THUMB_100_PREFIX . '.' . $exten;
        \yii\imagine\Image::thumbnail($path, 100, 100)->save($filenameto);
        $url = self::CACHE_IMAGE_URL . $name . self::THUMB_100_PREFIX . '.' . $exten;
        return $url;
    }

    public static function getThumbnail($image_url){
        if(!$image_url)
            return false;
        $image_path = self::getUrlPath($image_url);
        $pathinfo = pathinfo($image_path);
        $name = $pathinfo['filename'];
        $extention = $pathinfo['extension'];
        $thumbnail_url = self::CACHE_IMAGE_URL . $name . self::THUMB_100_PREFIX . '.' . $extention;
        $thumbnail_path = self::getUrlPath($thumbnail_url);
        if(!file_exists($thumbnail_path)){
            self::createThumbnail($image_url);
        }
        return $thumbnail_url;
    }

    public static function getFirstImageUrl($text){
        $result = [];
        $expression = '/<img\s+src="([^"]+)"[^>]*>/';
        $exp_count = preg_match_all($expression, $text, $result);
        if($exp_count != 0){
            return $result[1][0];
        }
        else return false;
    }

    public function upload(){
        $urlPath = self::getCurrentUrl();
        $pathWithoutName = self::getUrlPath($urlPath);
        $generatedName = uniqid();
        $urlPath = $urlPath . $generatedName . '.' . $this->imageFile->extension;
        $path = self::getUrlPath($urlPath);
        self::controlPath($pathWithoutName);
        if($this->validate()) {
            $this->imageFile->saveAs($path);
            return $urlPath;
        }
        return false;
    }


}
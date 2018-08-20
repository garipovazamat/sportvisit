<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "organization".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $phone
 * @property string $name
 * @property string $descript
 * @property string $url_address
 * @property string $coordinates
 * @property string $address
 * @property integer $id_avatar
 * @property integer $id_city
 * @property string $email
 *
 * @property Event[] $events
 * @property Image $idAvatar
 * @property User $user
 * @property Sports[] $sports
 * @property City $city
 */
class Organization extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'organization';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_avatar'], 'integer'],
            [['name'], 'required'],
            [['descript', 'phone'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['coordinates'], 'string', 'max' => 80],
            [['address'], 'string', 'max' => 150],
            [['name'], 'unique'],
            ['url_address', 'string', 'min' => 3, 'max' => 30],
            ['id_city', 'integer'],
            ['id_city', 'default'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'name' => 'Название',
            'descript' => 'Описание',
            'coordinates' => 'Укажите местоположение на карте (нажмите на карте)',
            'address' => 'Адрес',
            'phone' => 'Телефон',
            'id_avatar' => 'Id Avatar',
            'url_address' => 'Адрес в строке браузера, будет идти после адреса сайта, например: sportgid.net/myorg',
            'id_city' => 'Город',
            'email' => 'Электронная почта организации'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['id_org' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAvatar()
    {
        return $this->hasOne(Image::className(), ['id' => 'id_avatar']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public function getSports()
    {
        return $this->hasMany(OrgSport::className(), ['id_org' => 'id']);
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'id_city']);
    }

    public function beforeSave(){
        if(parent::beforeSave(true)){
            $userId = Yii::$app->user->id;
            $this->id_user = $userId;
        }
        return true;
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        if(empty($this->url_address)) {
            $this->url_address = 'id' . $this->id;
            $this->save();
        }
    }

    public function getTextWithoutTags(){
        $text = strip_tags($this->descript, '<p>');
        return $text;
    }

    public function getShortText($count){
        $text = $this->getTextWithoutTags();
        $shortText = mb_substr($text, 0, $count, 'UTF-8');
        return $shortText;
    }
    public function getFirstImageUrl(){
        return Image::getFirstImageUrl($this->descript);
    }

    /**
     * @param $id
     * @return null|Organization
     */
    public static function findOrgById($id){
        $model = Organization::findOne(['id' => $id]);
        return $model;
    }

    public static function findOrgByShortUrl($id){
        $model = Organization::findOne(['url_address' => $id]);
        return $model;
    }

    /**
     * @return bool
     * Определяет, является ли текущий пользователь владельцем
     */
    public function isOwner(){
        if(Yii::$app->user->isGuest)
            return false;
        if(Yii::$app->user->can('updateOrg')) {
            return true;
        }
        $userId = Yii::$app->user->id;
        if($this->id_user == $userId)
            return true;
        return false;
    }

    public static function getIndexUrl(){
        $url = Url::to(['organization/index']);
        return $url;
    }

    public static function getCreateUrl(){
        $url = Url::to(['organization/create']);
        return $url;
    }
}
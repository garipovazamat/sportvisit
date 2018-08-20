<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property string $name
 */
class City extends \yii\db\ActiveRecord
{
    const SESSION_KEY = 'id_city';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'safe'],
            //[['name'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Выберите город',
            'name' => 'Name',
        ];
    }

    public static function getCityList(){
        $cities = City::find()->all();
        return ArrayHelper::map($cities, 'id', 'name');
    }

    public static function hasSessionCity(){
        return Yii::$app->session->has(self::SESSION_KEY);
    }

    public static function getSessionCityId(){
        if(self::hasSessionCity()) {
            $cityId = Yii::$app->session->get(self::SESSION_KEY);
            return $cityId;
        }
        return false;
    }

    public static function getSessionCity(){
        $cityId = self::getSessionCityId();
        if($cityId){
            $city = City::findOne(['id' => $cityId]);
            return $city;
        }
        return $cityId;
    }

    public static function setSessionCity($idCity){
        Yii::$app->session->set(self::SESSION_KEY, $idCity);
    }

    public static function deleteSessionCity(){
        $session = Yii::$app->session;
        if($session->has(self::SESSION_KEY))
            Yii::$app->session->remove(self::SESSION_KEY);
    }


}

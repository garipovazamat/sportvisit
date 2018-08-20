<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_city
 * @property integer $type
 * @property string $name
 * @property string $text
 * @property string $add_datetime
 *
 * @property Event $event
 * @property User $idUser
 */
class News extends \yii\db\ActiveRecord
{
    const EVENT_TYPE = 1;
    const NEWS_TYPE = 2;
    const ARTICLE_TYPE = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user'], 'integer'],
            [['name', 'text', 'add_datetime'], 'required'],
            [['text'], 'string'],
            [['add_datetime'], 'safe'],
            [['name'], 'string', 'max' => 50],
            ['id_city', 'integer'],
            ['id_city', 'default'],
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
            'name' => 'Name',
            'text' => 'Text',
            'add_datetime' => 'Add Datetime',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id_news' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public function getFirstImageUrl(){
        return Image::getFirstImageUrl($this->text);
    }

    public function getTextWithoutTags(){
        $text = strip_tags($this->text, '<p>');
        return $text;
    }

    public function getShortText($count){
        $text = $this->getTextWithoutTags();
        $shortText = mb_substr($text, 0, $count, 'UTF-8');
        return $shortText;
    }

    /**
     * @return string
     * Получить дату создания
     */
    public function getCreateDate(){
        $date = Yii::$app->formatter->asDatetime($this->add_datetime);
        return $date;
    }

    public function isAutor(){
        $userId = Yii::$app->user->id;
        if($this->id_user == $userId)
            return true;
        return false;
    }


}

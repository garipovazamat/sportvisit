<?php

namespace common\models;

use Yii;
use yii\helpers\Html;
use yii\db\ActiveQuery;
use yii\db\Query;

/**
 * This is the model class for table "request".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_event
 * @property integer $time_request
 * @property boolean $is_child
 * @property string $name
 * @property integer $age
 *
 * @property Event $event
 * @property User $user
 */
class Request extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_event', 'time_request'], 'integer'],
            ['name', 'string', 'min' => 2, 'max' => 50],
            ['age', 'integer']
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
            'id_event' => 'Id Event',
            'time_request' => 'Time Request',
            'name' => 'Имя',
            'age' => 'Возраст'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'id_event']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @param $id_event
     * @return bool|Request
     * Определяет, есть ли запрос от текущего пользователя
     * если есть, возвращает этот запрос, иначе возвращает false
     */
    public static function isEventRequest($id_event){
        $userId = Yii::$app->user->id;
        $query = Request::find()
            ->where(['id_user' => $userId, 'id_event' => $id_event]);
        $count = $query->count();
        if($count > 0)
            return $query->one();
        return false;
    }

    /**
     * @param $id_event
     * @return ActiveQuery
     * Возвращает запрос на получение всех заявок на event
     */
    private static function getEventRequestQuery($id_event){
        $query = Request::find()
            ->where(['id_event' => $id_event]);
        return $query;
    }

    /**
     * @param $id_event
     * @return Request[]
     * Возвращает все заявки на event
     */
    public static function getEventRequests($id_event){
        $query = self::getEventRequestQuery($id_event);
        return $query->all();
    }

    public function sendMail(){
        $owner = $this->event->org->user;
        $event = $this->event;
        $text = "Уважаемый " . $owner->getAllname() .
            ". На " . (($event->isSection()) ? "вашу секцию" : "ваше мероприятие") .
            " " . Html::a($event->news->name, $event->getViewUrl(true)) .
            " подана заявка";

        $user = $this->user;
        if(!$this->is_child) {
            $form = "Имя Фамилия: " . $user->getAllname();
            $form = $form . "<br>Электронная почта: " . $user->email;
            if (!empty($user->phone))
                $form = $form . "<br>Телефон: " . $user->phone;
            if (!empty($user->id_vk))
                $form = $form . "<br>Страница Вконтакте: "
                    . Html::a('ссылка', $user->getVkUrl());
        }else{
            $form = "Пользователь оставил заявку от ребенка";
            $form = $form . "<br>Имя ребенка: " . $this->name;
            $form = $form . "<br>Возраст: " . $this->age;
            $form = $form . "<br>Электронная почта: " . $user->email;
        }
        $user_link = "Профиль пользователя: " .
            Html::a('ссылка', $user->getUrlProfile(null, true));
        $message = "<p>" . $text . "</p>"
            . "<p>" . $form . "</p>"
            . "<p>" . $user_link . "</p>";

        $subject = 'Заявка в вашу организацию';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: SportVisit.ru <sportvisit@sportvisit.ru>' . "\r\n";
        $email = (!empty($this->event->org->email)) ? $this->event->org->email : $owner->email;
        //$email = 'uch-aza@yandex.ru';
        return mail($email, $subject, $message, $headers);
    }
}
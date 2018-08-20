<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "event".
 *
 * @property integer $id
 * @property integer $id_sport
 * @property integer $age_from
 * @property integer $type
 * @property integer $age_to
 * @property integer $id_news
 * @property integer $id_org
 * @property string $coords
 * @property string $date_from
 * @property string $date_to
 *
 * @property News $news
 * @property Organization $org
 * @property Sports $sport
 */
class Event extends \yii\db\ActiveRecord
{

    const TYPE_EVENT = 0;
    const TYPE_SECTION = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_from', 'id_news'], 'required'],
            [['date_from', 'date_to'], 'integer'],
            ['date_to', 'integer'],
            ['date_to', 'default'],
            [['id_news'], 'integer'],
            [['id_news'], 'unique'],
            ['id_org', 'safe'],
            ['coords', 'string'],
            ['age_from', 'integer', 'min' => 2],
            ['type', 'integer'],
            ['type', 'default', 'value' => self::TYPE_EVENT],
            ['id_sport', 'integer'],
            ['id_sport', 'default'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'id_news' => 'Id News',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'id_news']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrg()
    {
        return $this->hasOne(Organization::className(), ['id' => 'id_org']);
    }

    public function getSport(){
        return $this->hasOne(Sports::className(), ['id' => 'id_sport']);
    }

    public function getStartDate(){
        $startDate = $this->date_from;
        return Yii::$app->formatter->asDatetime($startDate);
    }
    public function getEndDate(){
        $endDate = $this->date_to;
        return Yii::$app->formatter->asDatetime($endDate);
    }

    /**
     * @param $id
     * @return null|Event
     */
    public static function findById($id){
        $event = Event::findOne(['id' => $id]);
        return $event;
    }

    public function isHaveCoords(){
        if(!empty($this->coords))
            return true;
        return false;
    }

    public function getViewUrl($full = false){
        $url = Url::to(['event/view', 'id' => $this->id], $full);
        return $url;
    }

    public static function getIndexUrl(){
        $url = Url::to(['event/index']);
        return $url;
    }

    public static function getSectionsUrl(){
        $url = Url::to(['event/section']);
        return $url;
    }

    public function getUpdateUrl(){
        if($this->type == self::TYPE_EVENT)
            $url = Url::to(['event/update', 'id' => $this->id]);
        else $url = Url::to(['event/update', 'id' => $this->id, 'isSection' => true]);
        return $url;
    }


    /**
     * @param $form Request
     * @return bool|Request
     */
    public function createRequest($form = null){
        $userId = Yii::$app->user->id;
        $request = new Request();
        $request->id_event = $this->id;
        $request->id_user = $userId;
        $request->time_request = time();
        $request->is_child = 0;
        if(isset($form)){
            $request->is_child = 1;
            $request->name = $form->name;
            $request->age = $form->age;
        }
        if($request->save()) {
            $request->sendMail();
            return $request;
        }
        else return false;
    }

    public function sendRequest(){

    }

    public function isHaveRequest(){
        if(Yii::$app->user->isGuest)
            return false;
        $userId = Yii::$app->user->id;
        $count = Request::find()
                ->where(['id_event' => $this->id, 'id_user' => $userId])
                ->count();
        if($count>0)
            return true;
        return false;
    }

    /**
     * Проверяет, можно ли оставлять заявку (по дате)
     */
    public function isInsideDate(){
        $current_time = time();

        if(!$this->isSection() && $this->date_from > $current_time)
            return true;

        if($this->date_from < $current_time){
            if(!empty($this->date_to)){
                if($this->date_to > $current_time)
                    return true;
            }
            else return true;
        }
        return false;
    }

    public function rememberUrl(){
        $session = Yii::$app->session;
        $eventUrl = $this->getViewUrl();
        $session->set('event', $eventUrl);
    }

    public static function previousUrl(){
        $session = Yii::$app->session;
        if($session->has('event'))
            $url = $session->get('event');
        else $url = Url::to(['site/index']);
        return $url;
    }

    /**
     * @return array|string
     * Возвращает массив из двух элементов
     * 1 - latitude, 0 - longitude
     */
    public function getCoords(){
        $coords = $this->coords;
        $coords = explode(',', $coords);
        return $coords;
    }

    /**
     * @param $events Event[]
     * @return array
     */
    public static function getMiddleCoord($events){
        $sum_coord = [0, 0];
        $coord_count = 0;
        foreach($events as $one_event){
            if(!empty($one_event->coords)){
                $coord = $one_event->getCoords();
                $sum_coord[0] = $sum_coord[0] + $coord[0];
                $sum_coord[1] = $sum_coord[1] + $coord[1];
                $coord_count++;
            }
        }
        $middle_coord = [$sum_coord[0]/$coord_count, $sum_coord[1]/$coord_count];
        return $middle_coord;
    }

    public function isSection(){
        if($this->type == self::TYPE_SECTION)
            return true;
        return false;
    }

    /**
     * @return bool
     * Проверяет, является ли текущий поользователь автором или админом
     */
    public function isAutor(){
        if(Yii::$app->user->isGuest)
            return false;
        if(Yii::$app->user->can('updateEvent')) {
            return true;
        }
        $cUserId = Yii::$app->user->id;
        if($cUserId == $this->news->id_user || $cUserId == $this->org->id_user)
            return true;
        return false;
    }

    public function getRequestCount(){
        $count = Request::find()
            ->where(['id_event' => $this->id])
            ->count();
        return $count;
    }
}

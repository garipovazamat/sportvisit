<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.02.16
 * Time: 18:13
 */

namespace common\models;

use yii\base\Model;
use Yii;

class EventForm extends Model
{
    public $event_id;
    public $name;
    public $text;
    public $user_id;
    public $add_datetime;
    public $date_from;
    public $date_to;
    public $coords;
    public $ageFrom;
    public $ageTo;
    public $isSection;
    public $id_sport;
    public $id_city;

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 50],

            ['text', 'required'],
            ['text', 'string', 'max' => 5000],

            ['user_id', 'safe'],

            ['date_from', 'required'],
            ['date_from', 'date_compare'],
            //['date_from', 'date', 'format' => 'dd MM yyyy - HH:ii P'],

            ['date_to', 'default'],

            ['coords', 'string'],

            ['id_sport', 'integer'],
            ['id_sport', 'default'],

            ['id_city', 'integer'],
            ['id_city', 'default']
        ];
    }

    public function age_compare($attribute, $params){
        if($this->age_from > $this->age_to){
            $this->addError($attribute, 'Начало интервала возрастов должно быть меньше конца');
        }
    }

    public function date_compare($attribute, $params){
        if((!empty($this->date_to)) && ($this->date_from > $this->date_to)){
            $this->addError($attribute, 'Дата начала должно быть меньше конца');
        }
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'text' => 'Описание',
            'date_from' => 'Дата начала',
            'date_to' => 'Дата окончания',
            'coords' => 'Отметьте место проведения на карте (нажатием на карте)',
            'age_from' => 'Возрастная группа от (лет)',
            'age_to' => 'до',
            'id_sport' => 'Вид спорта',
            'id_city' => 'Город, в котором проводится мероприятие',
        ];
    }

    public function saveNew($id_org){
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        $news = new News();
        $news->id_user = $this->user_id;
        $news->name = $this->name;
        $news->text = $this->text;
        $news->add_datetime = time();
        $news->type = News::EVENT_TYPE;
        $news->id_city = $this->id_city;
        if($news->save()){
            $event = new Event();
            $event->date_from = strtotime($this->date_from);
            if(!empty($event->date_to))
                $event->date_to = strtotime($this->date_to);
            $event->id_news = $news->id;
            $event->id_org = $id_org;
            $event->coords = $this->coords;
            $event->age_from = $this->ageFrom;
            $event->age_to = $this->ageTo;
            $event->id_sport = $this->id_sport;
            if($this->isSection)
                $event->type = Event::TYPE_SECTION;
            if($event->save()) {
                $transaction->commit();
                return true;
            }
            else {
                $transaction->rollBack();
                print_r($event->errors);
                return false;
            }
        }
        return false;
    }

    /**
     * @param $event Event
     * @return boolean
     * Загрузка полей формы из модели Event
     */
    public function loadEvent($event){
        $this->event_id = $event->id;
        $this->name = $event->news->name;
        $this->text = $event->news->text;
        $this->user_id = $event->news->id_user;
        $this->add_datetime = $event->news->add_datetime;
        if(!empty($event->date_from))
            $this->date_from = date('Y-m-d H:i', $event->date_from);
        if(!empty($event->date_to))
            $this->date_to = date('Y-m-d H:i', $event->date_to);
        $this->coords = $event->coords;
        $this->ageFrom = $event->age_from;
        $this->ageTo = $event->age_to;
        $this->id_sport = $event->id_sport;
        $this->id_city = $event->news->id_city;
    }

    public function update(){
        $event = Event::findById($this->event_id);
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();

        $event->date_from = strtotime($this->date_from);
        if(!empty($this->date_to))
            $event->date_to = strtotime($this->date_to);
        $event->coords = $this->coords;
        $event->age_from = $this->ageFrom;
        $event->age_to = $this->ageTo;
        $event->id_sport = $this->id_sport;
        if(!$event->save()) {
            $transaction->rollBack();
            print_r($event->errors);
            return false;
        }
        $news = $event->news;
        $news->name = $this->name;
        $news->text = $this->text;
        $news->id_city = $this->id_city;
        //$news->add_datetime = $this->add_datetime;
        if($news->save()) {
            $transaction->commit();
            return true;
        }
        else $transaction->rollBack();
        return false;
    }

    public function isNew(){
        if(!empty($this->event_id))
            return false;
        return true;
    }
}
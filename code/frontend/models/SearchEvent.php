<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.02.16
 * Time: 18:34
 */

namespace frontend\models;


use common\models\Event;
use common\models\News;
use yii\data\ActiveDataProvider;
use common\models\City;
use yii\db\Expression;

class SearchEvent extends Event
{

    public $isSection;

    public function rules()
    {
        return [
            [['id_org', 'type', 'id_sport'], 'integer'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id_sport' => 'Вид спорта',
        ];
    }

    public function search($params = null, $isSection = false, $withPast = false){

        $this->isSection = $isSection;

        $cTime = time();
        $deltaTimeExp = new Expression("date_from - $cTime AS `dtime`");
        $query = Event::find()->select(['`event`.*', $deltaTimeExp])->joinWith('news');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        /*if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }*/
        if(!$withPast && !$isSection) {
            $query->where('date_from >= '.time().' || date_to >= '.time());
        }
        elseif(!$withPast && $isSection) {
            $query->where('date_to >= '.time());
        }

        if($isSection)
            $query->andFilterWhere(['event.type' => Event::TYPE_SECTION]);
        else $query->andFilterWhere(['event.type' => Event::TYPE_EVENT]);

        $query->andFilterWhere([
            'id_org' => $this->id_org,
            'id_sport' => $this->id_sport,
        ]);

        if(City::hasSessionCity())
            $query->andFilterWhere([
                'id_city' => City::getSessionCityId()
            ]);

        $query->orderBy('dtime ASC');

        return $dataProvider;
    }
}
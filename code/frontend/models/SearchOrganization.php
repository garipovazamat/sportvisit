<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.02.16
 * Time: 15:04
 */
namespace frontend\models;

use common\models\Event;
use common\models\Organization;
use yii\data\ActiveDataProvider;
use common\models\City;

class SearchOrganization extends Organization
{
    public $sportId;

    public function rules()
    {
        return [
            ['id_city', 'integer'],
            ['id_city', 'default'],

            ['sportId', 'integer'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'sportId' => 'Вид спорта',
        ];
    }

    public function search($params = null){
        $query = Organization::find()->joinWith('sports');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        /*if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }*/

        if(City::hasSessionCity())
            $query->andFilterWhere([
                'id_city' => City::getSessionCityId(),
            ]);

        if(isset($this->sportId)){
            $query->andFilterWhere([
                'org_sport.id_sport' => $this->sportId
            ]);
        }
        $query->orderBy('id DESC');
        return $dataProvider;
    }
}
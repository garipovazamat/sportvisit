<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "org_sport".
 *
 * @property integer $id
 * @property integer $id_org
 * @property integer $id_sport
 *
 * @property Sports $sport
 * @property Organization $org
 */
class OrgSport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_sport';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_org', 'id_sport'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_org' => 'Id Org',
            'id_sport' => 'Вид спорта',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSport()
    {
        return $this->hasOne(Sports::className(), ['id' => 'id_sport']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrg()
    {
        return $this->hasOne(Organization::className(), ['id' => 'id_org']);
    }
}

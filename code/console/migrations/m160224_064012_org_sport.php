<?php

use yii\db\Schema;
use yii\db\Migration;

class m160224_064012_org_sport extends Migration
{
    public function up()
    {
        $this->createTable('org_sport', [
            'id' => $this->primaryKey(),
            'id_org' => $this->integer(),
            'id_sport' => $this->integer(),
        ]);
        $this->addForeignKey('fk_org_sport_org', 'org_sport', 'id_org',
            'organization', 'id');
        $this->addForeignKey('fk_org_sport_sport', 'org_sport', 'id_sport',
            'sports', 'id');
    }

    public function down()
    {
        echo "m160224_064012_org_sport cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}

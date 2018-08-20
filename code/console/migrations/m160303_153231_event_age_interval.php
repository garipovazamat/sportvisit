<?php

use yii\db\Schema;
use yii\db\Migration;

class m160303_153231_event_age_interval extends Migration
{
    public function up()
    {
        $this->addColumn('event', 'age_from', 'integer');
        $this->addColumn('event', 'age_to', 'integer');
    }

    public function down()
    {
        echo "m160303_153231_event_age_interval cannot be reverted.\n";

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

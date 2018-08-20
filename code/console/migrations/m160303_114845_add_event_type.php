<?php

use yii\db\Schema;
use yii\db\Migration;

class m160303_114845_add_event_type extends Migration
{
    public function up()
    {
        $this->addColumn('event', 'type', 'integer NOT NULL DEFAULT 0');
    }

    public function down()
    {
        echo "m160303_114845_add_event_type cannot be reverted.\n";

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

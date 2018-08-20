<?php

use yii\db\Schema;
use yii\db\Migration;

class m160309_134409_add_event_sport extends Migration
{
    public function up()
    {
        $this->addColumn('event', 'id_sport', 'integer DEFAULT NULL');
        $this->addForeignKey('fk_event_sport', 'event',
            'id_sport', 'sports', 'id');

    }

    public function down()
    {
        echo "m160309_134409_add_event_sport cannot be reverted.\n";

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

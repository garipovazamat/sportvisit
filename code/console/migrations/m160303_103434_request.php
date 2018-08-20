<?php

use yii\db\Schema;
use yii\db\Migration;

class m160303_103434_request extends Migration
{
    public function up()
    {
        $this->createTable('request', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer(),
            'id_event' => $this->integer(),
            'time_request' => $this->integer()
        ]);
        $this->addForeignKey('fk_request_user', 'request', 'id_user',
            'user', 'id');
        $this->addForeignKey('fk_request_event', 'request', 'id_event',
            'event', 'id');
    }

    public function down()
    {
        echo "m160303_103434_request cannot be reverted.\n";

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

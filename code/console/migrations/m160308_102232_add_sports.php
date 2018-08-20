<?php

use yii\db\Schema;
use yii\db\Migration;

class m160308_102232_add_sports extends Migration
{
    public function up()
    {
        $this->insert('sports', ['name' => 'Дворовый спорт']);
        $this->insert('sports', ['name' => 'Туризм']);
        $this->insert('sports', ['name' => 'Интеллектуальные виды спорта']);
        $this->insert('sports', ['name' => 'Единоборства']);
        $this->insert('sports', ['name' => 'Киберспорт']);
        $this->insert('sports', ['name' => 'Фитнес']);
        $this->insert('sports', ['name' => 'Футбол']);


    }

    public function down()
    {
        echo "m160308_102232_add_sports cannot be reverted.\n";

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

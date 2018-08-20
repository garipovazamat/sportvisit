<?php

use yii\db\Schema;
use yii\db\Migration;

class m160310_074436_city_and_time extends Migration
{
    public function up()
    {
        $this->truncateTable('city');
        $this->addColumn('city', 'utf_zone', 'integer');

        $this->insert('city', ['name' => 'Челябинск', 'utf_zone' => 6]);
        $this->insert('city', ['name' => 'Екатеринбург', 'utf_zone' => 6]);
        $this->insert('city', ['name' => 'Москва', 'utf_zone' => 4]);
        $this->insert('city', ['name' => 'Уфа', 'utf_zone' => 6]);
        $this->insert('city', ['name' => 'Санкт-Петербург', 'utf_zone' => 4]);
    }

    public function down()
    {
        echo "m160310_074436_city_and_time cannot be reverted.\n";

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

<?php

use yii\db\Schema;
use yii\db\Migration;

class m160214_091010_city extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('city',[
            'id' => $this->primaryKey(),
            'name' => $this->string(40)->notNull(),
        ], $tableOptions);
        $this->insert('city',['name' => 'Челябинск']);
    }

    public function down()
    {
        echo "m160214_091010_city cannot be reverted.\n";

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

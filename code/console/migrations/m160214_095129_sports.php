<?php

use yii\db\Schema;
use yii\db\Migration;

class m160214_095129_sports extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('sports', [
            'id' => $this->primaryKey(),
            'name' => $this->string(30)->notNull()->unique(),
        ], $tableOptions);
        $this->insert('sports', ['name' => 'аэробика']);
        $this->insert('sports', ['name' => 'бодибилдинг']);
        $this->insert('sports', ['name' => 'бокс']);
        $this->insert('sports', ['name' => 'йога']);
        $this->insert('sports', ['name' => 'сноубординг']);
    }

    public function down()
    {
        echo "m160214_095129_sports cannot be reverted.\n";

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

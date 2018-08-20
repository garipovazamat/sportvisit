<?php

use yii\db\Schema;
use yii\db\Migration;

class m160214_091837_news extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer(),
            'name' => $this->string(50)->notNull(),
            'text' => $this->text()->notNull(),
            'add_datetime' => $this->integer()->notNull(),
            'type' => $this->integer()->defaultValue(0),
        ], $tableOptions);
        $this->addForeignKey('fk_news_user_id', 'news', 'id_user', 'user', 'id');
    }

    public function down()
    {
        echo "m160214_091837_news cannot be reverted.\n";

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

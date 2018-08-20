<?php

use yii\db\Schema;
use yii\db\Migration;

class m160214_101302_event extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('event',[
            'id' =>$this->primaryKey(),
            'date_from' => $this->integer()->notNull(),
            'date_to' => $this->integer(),
            'id_news' => $this->integer()->notNull()->unique(),
        ], $tableOptions);
        $this->addForeignKey('fk_event_news', 'event', 'id_news', 'news', 'id');
    }

    public function down()
    {
        echo "m160214_101302_event cannot be reverted.\n";

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

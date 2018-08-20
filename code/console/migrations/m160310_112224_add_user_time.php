<?php

use yii\db\Schema;
use yii\db\Migration;

class m160310_112224_add_user_time extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'id_city', 'integer DEFAULT NULL');
    }

    public function down()
    {
        echo "m160310_112224_add_user_time cannot be reverted.\n";

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

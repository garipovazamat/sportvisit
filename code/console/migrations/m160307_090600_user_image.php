<?php

use yii\db\Schema;
use yii\db\Migration;

class m160307_090600_user_image extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'avatar_url', 'string');
    }

    public function down()
    {
        echo "m160307_090600_user_image cannot be reverted.\n";

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

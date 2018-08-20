<?php

use yii\db\Schema;
use yii\db\Migration;

class m160227_163235_user_org extends Migration
{
    public function up()
    {
        $this->createTable('user_org', [
            'id' => $this->primaryKey(),
            'id_org' => $this->integer(),
            'id_user' => $this->integer(),
        ]);
        $this->addForeignKey('fk_user_org_org', 'user_org', 'id_org',
            'organization', 'id');
        $this->addForeignKey('fk_user_org_user', 'user_org', 'id_user',
            'user', 'id');
    }

    public function down()
    {
        echo "m160227_163235_user_org cannot be reverted.\n";

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

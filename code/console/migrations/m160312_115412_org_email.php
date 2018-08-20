<?php

use yii\db\Schema;
use yii\db\Migration;

class m160312_115412_org_email extends Migration
{
    public function up()
    {
        $this->addColumn('organization', 'email', 'string');

    }

    public function down()
    {
        echo "m160312_115412_org_email cannot be reverted.\n";

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

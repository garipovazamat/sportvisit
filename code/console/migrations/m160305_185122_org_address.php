<?php

use yii\db\Schema;
use yii\db\Migration;

class m160305_185122_org_address extends Migration
{
    public function up()
    {
        $this->addColumn('organization', 'url_address', 'string');
    }

    public function down()
    {
        echo "m160305_185122_org_address cannot be reverted.\n";

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

<?php

use yii\db\Schema;
use yii\db\Migration;

class m160226_132929_add_date_org extends Migration
{
    public function up()
    {
        $this->addColumn('organization', 'add_date', 'integer');
    }

    public function down()
    {
        echo "m160226_132929_add_date_org cannot be reverted.\n";

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

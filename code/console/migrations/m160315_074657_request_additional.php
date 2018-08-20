<?php

use yii\db\Schema;
use yii\db\Migration;

class m160315_074657_request_additional extends Migration
{
    public function up()
    {
        $this->addColumn('request', 'is_child', 'boolean DEFAULT 0');
        $this->addColumn('request', 'name', 'string CHARSET utf8');
        $this->addColumn('request', 'age', 'integer');
    }

    public function down()
    {
        $this->dropColumn('request', 'is_child');
        $this->dropColumn('request', 'name');
        $this->dropColumn('request', 'age');

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

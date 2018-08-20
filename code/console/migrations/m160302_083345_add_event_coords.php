<?php

use yii\db\Schema;
use yii\db\Migration;

class m160302_083345_add_event_coords extends Migration
{
    public function up()
    {
        $this->addColumn('event', 'coords', 'string');
    }

    public function down()
    {
        echo "m160302_083345_add_event_coords cannot be reverted.\n";

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

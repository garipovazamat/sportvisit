<?php

use yii\db\Schema;
use yii\db\Migration;

class m160311_081647_add_id_city extends Migration
{
    public function up()
    {
        $this->addForeignKey('fk_user_city', 'user', 'id_city', 'city', 'id');

        $this->addColumn('news', 'id_city', 'integer');
        $this->addColumn('organization', 'id_city', 'integer');

        $this->addForeignKey('fk_news_city', 'news', 'id_city', 'city', 'id');
        $this->addForeignKey('fk_org_city', 'organization', 'id_city', 'city', 'id');
    }

    public function down()
    {
        echo "m160311_081647_add_id_city cannot be reverted.\n";

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

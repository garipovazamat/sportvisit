<?php

use yii\db\Schema;
use yii\db\Migration;

class m160222_121903_organization extends Migration
{
    public function up()
    {
        $this->createTable('image', [
            'id' => $this->primaryKey(),
            'url' => $this->string()
        ]);
        $this->createTable('organization', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer(),
            'name' => $this->string(50)->notNull()->unique(),
            'descript' => $this->text(),
            'coordinates' => $this->string(80),
            'address' => $this->string(150),
            'id_avatar' => $this->integer(),
            'phone' => $this->string(20),
        ]);
        $this->addForeignKey('fk_org_user',
            'organization', 'id_user',
            'user', 'id');
        $this->addForeignKey('fk_org_image',
            'organization', 'id_avatar',
            'image', 'id');

        $this->addColumn('event', 'id_org', 'integer');
        $this->addForeignKey('fk_event_org', 'event', 'id_org',
            'organization', 'id');

    }

    public function down()
    {
        echo "m160222_121903_organization cannot be reverted.\n";

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

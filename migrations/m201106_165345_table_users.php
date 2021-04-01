<?php

use yii\db\Migration;

/**
 * Class m201106_165345_table_users
 */
class m201106_165345_table_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'mail' => $this->string(255)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'name_surname' => $this->string(255)->notNull(),
            'behaviors' => $this->integer(10)->defaultValue(10)->notNull()
        ]);
        $this->insert('users', [
            'mail' => 'admin@admin.ru',
            'password' => 'admin',
            'name_surname' => 'admin admin',
            'behaviors' => '1',
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201106_165345_table_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201106_165345_table_users cannot be reverted.\n";

        return false;
    }
    */
}

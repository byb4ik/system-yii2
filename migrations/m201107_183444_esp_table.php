<?php

use yii\db\Migration;

/**
 * Class m201107_183444_esp_table
 */
class m201107_183444_esp_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('esp', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(10)->notNull(),
            'valve' => $this->integer(10)->notNull(),
            'liter_base' => $this->double(10),
            'liter_balance' => $this->double(10),
            'liter_all_time' => $this->double(10),
            'liter_from_esp' => $this->double(10),
            'esp_id' => $this->string(100)->notNull()
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201107_183444_esp_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201107_183444_esp_table cannot be reverted.\n";

        return false;
    }
    */
}

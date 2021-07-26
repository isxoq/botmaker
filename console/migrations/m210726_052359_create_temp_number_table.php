<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%temp_number}}`.
 */
class m210726_052359_create_temp_number_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%temp_number}}', [

            'id' => $this->primaryKey(),
            'phone' => $this->string(),
            'code' => $this->integer(),
            'password' => $this->string(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'status' => $this->smallInteger(),
            'code_expire_at' => $this->integer(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%temp_number}}');
    }
}

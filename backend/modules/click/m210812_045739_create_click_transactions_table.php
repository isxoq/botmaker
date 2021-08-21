<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%click_transactions}}`.
 */
class m210812_045739_create_click_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%click_transactions}}', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'click_trans_id' => $this->integer(),
            'amount' => $this->integer(),
            'click_paydoc_id' => $this->integer(),
            'service_id' => $this->integer(),
            'sign_time' => $this->string(),
            'status' => $this->tinyInteger(),
            'created_at' => $this->integer()

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%click_transactions}}');
    }
}

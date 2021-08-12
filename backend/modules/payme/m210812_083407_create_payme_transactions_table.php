<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payme_transactions}}`.
 */
class m210812_083407_create_payme_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payme_transactions}}', [
            'id' => $this->primaryKey(),
            'paycom_transaction_id' => $this->string(),
            'paycom_time' => $this->string(),
            'paycom_time_datetime' => $this->dateTime(),
            'create_time' => $this->dateTime(),
            'perform_time' => $this->dateTime(),
            'cancel_time' => $this->dateTime(),
            'amount' => $this->integer(),
            'state' => $this->smallInteger(),
            'reason' => $this->tinyInteger(),
            'receivers' => $this->string(),
            'order_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payme_transactions}}');
    }
}

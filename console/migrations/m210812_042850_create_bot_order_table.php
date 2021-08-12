<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bot_order}}`.
 */
class m210812_042850_create_bot_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bot_order}}', [

            'id' => $this->primaryKey(),
            'bot_id' => $this->integer(),
            'user_id' => $this->integer(),
            'month' => $this->smallInteger(),
            'amount' => $this->integer(),
            'state' => $this->smallInteger(),
            'created_at' => $this->integer(),
            'coupon' => $this->string()->null(),

        ]);

        $this->addForeignKey('bot_order_bot_id_fk', 'bot_order', 'bot_id', 'telegram_bot', 'id', 'RESTRICT');
        $this->addForeignKey('bot_order_user_id_fk', 'bot_order', 'user_id', 'user', 'id', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('bot_order_bot_id_fk', 'bot_order');
        $this->dropForeignKey('bot_order_user_id_fk', 'bot_order');
        $this->dropTable('{{%bot_order}}');
    }
}

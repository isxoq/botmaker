<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m210730_065105_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'bot_id' => $this->integer(),
            'created_at' => $this->integer(),
            'user_id' => $this->integer(),
            'status' => $this->smallInteger(),
            'total_price' => $this->integer(),
            'payment_status' => $this->smallInteger(),
            'payment_type' => $this->smallInteger(),
            'comment' => $this->text()
        ]);

        $this->addForeignKey('order_bot_id_fk', 'order', 'bot_id', 'telegram_bot', 'id', 'RESTRICT');
        $this->addForeignKey('order_user_id_fk', 'order', 'user_id', 'bot_user', 'id', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('order_bot_id_fk', 'order');
        $this->dropForeignKey('order_user_id_fk', 'order');
        $this->dropTable('{{%order}}');
    }
}

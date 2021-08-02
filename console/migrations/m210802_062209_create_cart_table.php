<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cart}}`.
 */
class m210802_062209_create_cart_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cart}}', [

            'id' => $this->primaryKey(),
            'bot_id' => $this->integer(),
            'bot_user_id' => $this->integer(),
            'product_id' => $this->integer(),
            'product_variant_id' => $this->integer(),
            'price' => $this->integer(),
            'quantity' => $this->integer(),


        ]);
        $this->addForeignKey('bot_id_fk_cart', 'cart', 'bot_id', 'telegram_bot', 'id', 'CASCADE');
        $this->addForeignKey('bot_user_id_fk_cart', 'cart', 'bot_user_id', 'bot_user', 'id', 'CASCADE');
        $this->addForeignKey('bot_product_id_fk_cart', 'cart', 'product_id', 'product', 'id', 'CASCADE');
        $this->addForeignKey('bot_product_variant_id_fk_cart', 'cart', 'product_variant_id', 'product_variant', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('bot_id_fk_cart', 'cart');
        $this->dropForeignKey('bot_user_id_fk_cart', 'cart');
        $this->dropForeignKey('bot_product_id_fk_cart', 'cart');
        $this->dropForeignKey('bot_product_variant_id_fk_cart', 'cart');
        $this->dropTable('{{%cart}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Class m210816_093226_add_fields_to_telegram_bot_table
 */
class m210816_093226_add_fields_to_telegram_bot_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('telegram_bot', 'delivery_price', 'integer');
        $this->addColumn('telegram_bot', 'min_order_price', 'integer');
        $this->addColumn('telegram_bot', 'about_image', 'string');
        $this->addColumn('telegram_bot', 'about_text', 'text');
        $this->addColumn('telegram_bot', 'is_active', 'integer');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('telegram_bot', 'delivery_price');
        $this->dropColumn('telegram_bot', 'min_order_price');
        $this->dropColumn('telegram_bot', 'about_image');
        $this->dropColumn('telegram_bot', 'about_text');
        $this->dropColumn('telegram_bot', 'is_active');
    }


}

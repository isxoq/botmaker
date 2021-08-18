<?php

use yii\db\Migration;

/**
 * Class m210818_052910_add_fields_to_telegram_bot_table
 */
class m210818_052910_add_fields_to_telegram_bot_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('telegram_bot', 'click_merchant_id', 'string');
        $this->addColumn('telegram_bot', 'click_merchant_user_id', 'string');
        $this->addColumn('telegram_bot', 'click_service_id', 'string');
        $this->addColumn('telegram_bot', 'click_secret_key', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('telegram_bot', 'click_merchant_id');
        $this->dropColumn('telegram_bot', 'click_merchant_user_id');
        $this->dropColumn('telegram_bot', 'click_service_id');
        $this->dropColumn('telegram_bot', 'click_secret_key');
    }

}

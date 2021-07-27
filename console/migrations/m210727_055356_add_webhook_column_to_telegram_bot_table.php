<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%telegram_bot}}`.
 */
class m210727_055356_add_webhook_column_to_telegram_bot_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('telegram_bot', 'webhook', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('telegram_bot', 'webhook');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%telegram_bot}}`.
 */
class m210812_093843_add_active_to_column_to_telegram_bot_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('telegram_bot', 'active_to', 'integer');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('telegram_bot', 'active_to');
    }
}

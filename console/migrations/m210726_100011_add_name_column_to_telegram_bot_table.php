<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%telegram_bot}}`.
 */
class m210726_100011_add_name_column_to_telegram_bot_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('telegram_bot', 'name', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('telegram_bot', 'name');
    }
}

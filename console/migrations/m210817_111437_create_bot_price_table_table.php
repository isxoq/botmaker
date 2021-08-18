<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bot_price_table}}`.
 */
class m210817_111437_create_bot_price_table_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bot_price_table}}', [
            'id' => $this->primaryKey(),
            'month' => $this->integer(),
            'price' => $this->integer()
        ]);

        for ($i = 1; $i <= 12; $i++) {
            $this->insert('bot_price_table', [
                'month' => $i,
                'price' => $i * 15000
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bot_price_table}}');
    }
}

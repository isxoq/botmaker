<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m210727_081953_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [

            'id' => $this->primaryKey(),
            'bot_id' => $this->integer(),
            'parent_id' => $this->integer()->defaultValue(0),
            'name' => $this->string(),
            'description' => $this->text(),
            'order_id' => $this->integer(),
            'image' => $this->string(),
            'status' => $this->smallInteger(),

        ]);

        $this->addForeignKey('bot_fk', 'category', 'bot_id', 'telegram_bot', 'id', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey('bot_fk', 'category');
        $this->dropTable('{{%category}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%telegram_bot}}`.
 */
class m210723_060751_create_telegram_bot_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%telegram_bot}}', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'token' => $this->string()->unique(),
            'bot_username' => $this->string()->null(),
            'bot_id' => $this->string()->null(),
            'type' => $this->string()->notNull(),
            'status' => $this->smallInteger()->defaultValue(1),

        ]);

        $this->addForeignKey('user_id_fk', 'telegram_bot', 'user_id', 'user', 'id', "RESTRICT");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('user_id_fk', 'telegram_bot');
        $this->dropTable('{{%telegram_bot}}');
    }
}

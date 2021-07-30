<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bot_user}}`.
 */
class m210730_081131_create_bot_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bot_user}}', [

            'id' => $this->primaryKey(),
            'bot_id' => $this->integer(),
            'user_id' => $this->string(),
            'username' => $this->string(),
            'phone' => $this->string(),
            'full_name' => $this->string(),
            'last_action_date' => $this->integer(),
            'status' => $this->smallInteger()->defaultValue(1)

        ]);

        $this->addForeignKey('bot_user_bot_id_fk', 'bot_user', 'bot_id', 'telegram_bot', 'id', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('bot_user_bot_id_fk', 'bot_user');
        $this->dropTable('{{%bot_user}}');
    }
}

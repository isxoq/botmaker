<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bot_user_visit}}`.
 */
class m210805_045413_create_bot_user_visit_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bot_user_visit}}', [

            'id' => $this->primaryKey(),
            'bot_id' => $this->integer(),
            'bot_user_id' => $this->integer(),
            'datetime' => $this->integer(),
            'use_count' => $this->integer()

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bot_user_visit}}');
    }
}

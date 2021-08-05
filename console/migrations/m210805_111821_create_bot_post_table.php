<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bot_post}}`.
 */
class m210805_111821_create_bot_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bot_post}}', [
            'id' => $this->primaryKey(),
            'image' => $this->string(),
            'caption' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bot_post}}');
    }
}

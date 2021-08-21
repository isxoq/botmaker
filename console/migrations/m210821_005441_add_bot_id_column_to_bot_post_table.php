<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%bot_post}}`.
 */
class m210821_005441_add_bot_id_column_to_bot_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('bot_post', 'bot_id', 'integer');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('bot_post', 'bot_id');
    }
}

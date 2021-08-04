<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%bot_user}}`.
 */
class m210804_093205_add_lang_column_to_bot_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('bot_user', 'lang', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('bot_user', 'lang');
    }
}

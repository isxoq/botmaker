<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%answer_tiket}}`.
 */
class m210825_105007_create_answer_tiket_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%answer_tiket}}', [
            'id' => $this->primaryKey(),
            'tiket_id' => $this->integer(),
            'user_id' => $this->integer(),
            'message' => $this->text(),
            'file' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%answer_tiket}}');
    }
}

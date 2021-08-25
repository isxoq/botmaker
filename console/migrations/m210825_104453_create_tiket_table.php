<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tiket}}`.
 */
class m210825_104453_create_tiket_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tiket}}', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'email' => $this->string(),
            'phone' => $this->string(),
            'subject' => $this->string(),
            'message' => $this->text(),
            'file' => $this->string(),
            'status' => $this->integer()

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tiket}}');
    }
}

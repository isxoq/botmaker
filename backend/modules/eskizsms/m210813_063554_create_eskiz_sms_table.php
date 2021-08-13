<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%eskiz_sms}}`.
 */
class m210813_063554_create_eskiz_sms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%eskiz_sms}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'key' => $this->text()
        ]);

        $this->insert('eskiz_sms', [
            'username' => "login",
            'password' => "passwprd"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%eskiz_sms}}');
    }
}

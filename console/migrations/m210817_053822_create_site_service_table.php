<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%site_service}}`.
 */
class m210817_053822_create_site_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%site_service}}', [
            'id' => $this->primaryKey(),
            'icon' => $this->string(),
            'title' => $this->string(),
            'description' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%site_service}}');
    }
}

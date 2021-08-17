<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%site_app_clips}}`.
 */
class m210817_053934_create_site_app_clips_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%site_app_clips}}', [
            'id' => $this->primaryKey(),
            'image' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%site_app_clips}}');
    }
}

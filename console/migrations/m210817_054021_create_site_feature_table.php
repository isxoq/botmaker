<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%site_feature}}`.
 */
class m210817_054021_create_site_feature_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%site_feature}}', [
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
        $this->dropTable('{{%site_feature}}');
    }
}

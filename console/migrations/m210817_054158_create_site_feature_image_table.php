<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%site_feature_image}}`.
 */
class m210817_054158_create_site_feature_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%site_feature_image}}', [
            'id' => $this->primaryKey(),
            'image' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%site_feature_image}}');
    }
}

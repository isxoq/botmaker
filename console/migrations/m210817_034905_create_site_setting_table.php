<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%site_setting}}`.
 */
class m210817_034905_create_site_setting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%site_setting}}', [

            'id' => $this->primaryKey(),
            'key' => $this->string(),
            'image' => $this->string(),
            'value_uz' => $this->text(),
            'value_ru' => $this->text(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%site_setting}}');
    }
}

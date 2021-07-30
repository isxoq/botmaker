<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m210730_133247_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [

            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'category_id' => $this->integer(),
            'old_price' => $this->integer(),
            'price' => $this->integer()->notNull(),
            'description' => $this->text(),
            'image' => $this->string(),

        ]);

        $this->addForeignKey('category_id_fk', 'product', 'category_id', 'category', 'id', "CASCADE");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('category_id_fk', 'product');
        $this->dropTable('{{%product}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_variant}}`.
 */
class m210730_133535_create_product_variant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_variant}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'name' => $this->string(),
            'old_price' => $this->integer(),
            'price' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('product_id_fk', 'product_variant', 'product_id', 'product', 'id', "CASCADE");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('product_id_fk', 'product_variant');
        $this->dropTable('{{%product_variant}}');
    }
}

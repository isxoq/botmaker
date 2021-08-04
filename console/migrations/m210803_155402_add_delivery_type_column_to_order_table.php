<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%order}}`.
 */
class m210803_155402_add_delivery_type_column_to_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('order', 'delivery_type', 'integer');
        $this->addColumn('order', 'delivery_address', 'text');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('order', 'delivery_type');
        $this->dropColumn('order', 'delivery_address');
    }
}

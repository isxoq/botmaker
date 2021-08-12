<?php

use yii\db\Migration;

/**
 * Class m210812_110504_add_phone_column_to_bot_order
 */
class m210812_110504_add_phone_column_to_bot_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('bot_order', 'phone', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('bot_order', 'phone');
    }


}

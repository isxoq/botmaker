<?php

use yii\db\Migration;

/**
 * Class m210731_113042_add_step_to_user_table
 */
class m210731_113042_add_step_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('bot_user', 'old_step', 'string');
        $this->addColumn('bot_user', 'old_step_data', 'string');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('bot_user', 'old_step');
        $this->dropColumn('bot_user', 'old_step_data');
    }


}

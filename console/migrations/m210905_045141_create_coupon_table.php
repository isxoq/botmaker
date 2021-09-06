<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%coupon}}`.
 */
class m210905_045141_create_coupon_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%coupon}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'code' => $this->string(5),
            'amount' => $this->integer(),
            'active_to' => $this->integer(),
            'use_count' => $this->integer(),
            'status' => $this->smallInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%coupon}}');
    }
}

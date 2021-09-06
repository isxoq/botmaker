<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "coupon".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $code
 * @property int|null $amount
 * @property int|null $active_to
 * @property int|null $use_count
 * @property int|null $status
 */
class Coupon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coupon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['active_to', 'safe'],
            [['user_id', 'amount', 'use_count', 'status'], 'integer'],
            [['code'], 'string', 'max' => 5],
            ['code', 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'code' => Yii::t('app', 'Code'),
            'amount' => Yii::t('app', 'Amount'),
            'active_to' => Yii::t('app', 'Active To'),
            'use_count' => Yii::t('app', 'Use Count'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}

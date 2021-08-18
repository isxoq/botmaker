<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bot_price_table".
 *
 * @property int $id
 * @property int|null $month
 * @property int|null $price
 */
class BotPriceTable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bot_price_table';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month', 'price'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'month' => Yii::t('app', 'Month'),
            'price' => Yii::t('app', 'Price'),
        ];
    }
}

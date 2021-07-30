<?php

namespace frontend\modules\ecommerce\models;

use frontend\models\TelegramBot;
use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $bot_id
 * @property int|null $created_at
 * @property int|null $user_id
 * @property int|null $status
 * @property int|null $total_price
 * @property int|null $payment_status
 * @property int|null $payment_type
 * @property string|null $comment
 *
 * @property TelegramBot $bot
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bot_id', 'created_at', 'user_id', 'status', 'total_price', 'payment_status', 'payment_type'], 'integer'],
            [['comment'], 'string'],
            [['bot_id'], 'exist', 'skipOnError' => true, 'targetClass' => TelegramBot::className(), 'targetAttribute' => ['bot_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'bot_id' => Yii::t('app', 'Bot ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'user_id' => Yii::t('app', 'User ID'),
            'status' => Yii::t('app', 'Status'),
            'total_price' => Yii::t('app', 'Total Price'),
            'payment_status' => Yii::t('app', 'Payment Status'),
            'payment_type' => Yii::t('app', 'Payment Type'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }

    /**
     * Gets query for [[Bot]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBot()
    {
        return $this->hasOne(TelegramBot::className(), ['id' => 'bot_id']);
    }

    public static function find()
    {
        return parent::find()->joinWith('bot')->andWhere(['telegram_bot.id' => Yii::$app->controller->module->bot->id]);
    }
}

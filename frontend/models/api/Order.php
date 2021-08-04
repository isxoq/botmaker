<?php

namespace frontend\models\api;

use frontend\models\api\TelegramBot;
use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $bot_id
 * @property int|null $created_at
 * @property int|null $user_id
 * @property int|null $status
 * @property int|null $delivery_type
 * @property int|null $total_price
 * @property int|null $payment_status
 * @property int|null $payment_type
 * @property string|null $comment
// * @property int|null $paymentType
// * @property int|null $deliveryType
 * @property string|null $delivery_address
 *
 * @property TelegramBot $bot
 */
class Order extends \yii\db\ActiveRecord
{

    const STATUS_ORDERING = 9;

    const STATUS_PROCESSING = 1;
    const STATUS_VERIFIED = 2;
    const STATUS_BEING_DONE = 7;
    const STATUS_SUCCESS = 8;
    const STATUS_CANCELLED = 10;

    const PAYMENT_TYPE_CASH = 3;
    const PAYMENT_TYPE_TERMINAL = 4;

    const DELIVERY_TYPE_TO_ADDRESS = 5;
    const DELIVERY_TYPE_OWN = 6;

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
            ['delivery_type', 'integer'],
            ['delivery_address', 'string'],
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

    public static function paymentTypes()
    {
        return [
            self::PAYMENT_TYPE_CASH => t("Cash"),
            self::PAYMENT_TYPE_TERMINAL => t("Terminal")
        ];
    }

    public static function getPaymentTypeId($text)
    {
        switch ($text) {
            case t("Cash"):
                return self::PAYMENT_TYPE_CASH;
            case t("Terminal"):
                return self::PAYMENT_TYPE_TERMINAL;
            default:
                return 0;
        }
    }

    public static function deliveryTypes()
    {
        return [
            self::DELIVERY_TYPE_OWN => t("Olib ketish"),
            self::DELIVERY_TYPE_TO_ADDRESS => t("Yetkazib berish")
        ];
    }

    public static function getDeliveryTypeId($text)
    {
        switch ($text) {
            case t("Olib ketish"):
                return self::DELIVERY_TYPE_OWN;
            case t("Yetkazib berish"):
                return self::DELIVERY_TYPE_TO_ADDRESS;
            default:
                return 0;
        }
    }

    public function getPaymentType()
    {
        return self::paymentTypes()[$this->payment_type];
    }

    public function getDeliveryType()
    {
        return self::deliveryTypes()[$this->delivery_type];
    }

}

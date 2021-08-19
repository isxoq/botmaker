<?php

namespace frontend\modules\ecommerce\models;

use frontend\models\BotUserVisit;
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
 * @property int|null $delivery_type
 * @property int|null $total_price
 * @property int|null $payment_status
 * @property int|null $payment_type
 * @property int|null $is_digital
 * @property string|null $comment
 * // * @property int|null $paymentType
 * // * @property int|null $deliveryType
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

    const STATUS_PAYMENT_NO_PAY = 15;
    const STATUS_PAYMENT_PAYED = 16;

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
            [['delivery_type', 'is_digital'], 'integer'],
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


    public function getUser()
    {
        return $this->hasOne(BotUser::className(), ['id' => 'user_id']);
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

    public static function getOrderStatuses()
    {
        return [
            self::STATUS_PROCESSING => t('Processing'),
            self::STATUS_VERIFIED => t('Verified'),
            self::STATUS_BEING_DONE => t('Being done'),
            self::STATUS_SUCCESS => t('Success'),
            self::STATUS_CANCELLED => t('Cancelled'),
        ];
    }

    public function getOrderStatus()
    {
        return self::getOrderStatuses()[$this->status];
    }


    public static function getOrderPaymentStatuses()
    {
        return [
            self::STATUS_PAYMENT_NO_PAY => t('Not payed'),
            self::STATUS_PAYMENT_PAYED => t('payed'),
        ];
    }

    public function getOrderPaymentStatus()
    {
        return self::getOrderPaymentStatuses()[$this->payment_status];
    }

    public static function find()
    {
        return parent::find()->joinWith('bot')->andWhere(['telegram_bot.id' => Yii::$app->controller->module->bot->id]);
    }

    public static function weeklyOrders()
    {
        $days = [];
        $labels = [];

        for ($i = 0; $i <= 6; $i++) {
            $labels[] = date('Y-m-d', strtotime("-{$i} days"));
            $days[] = [
                'start' => date('Y-m-d 00:00:00', strtotime("-{$i} days")),
                'end' => date('Y-m-d 23:59:59', strtotime("-{$i} days"))
            ];
        }
        $orders = [];
        $days = array_reverse($days);

        foreach ($days as $day) {
            $orders[] = self::dayOrders($day);
        }

        $labels = json_encode(array_reverse($labels));
        $orders = json_encode($orders);
        return [
            'labels' => $labels,
            'orders' => $orders,
            'label' => t('Sales')
        ];
    }


    public static function dayOrders($day)
    {
        $today_visit = self::find()
            ->andWhere(['!=', 'order.status', self::STATUS_ORDERING])
            ->andWhere(['between', 'order.created_at', strtotime($day['start']), strtotime($day['end'])])
            ->count();
        return $today_visit;
    }

    public static function latestOrders()
    {
        return self::find()
            ->andWhere(['!=', 'order.status', self::STATUS_ORDERING])
            ->orderBy('order.created_at DESC')
            ->limit(5)
            ->all();
    }
}



<?php

namespace frontend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "bot_order".
 *
 * @property int $id
 * @property int|null $bot_id
 * @property int|null $user_id
 * @property int|null $month
 * @property int|null $amount
 * @property int|null $state
 * @property int|null $created_at
 * @property string|null $coupon
 *
 * @property TelegramBot $bot
 * @property User $user
 */
class BotOrder extends \yii\db\ActiveRecord
{

    const STATE_WAITING_PAYMENT = 1;
    const STATE_PAYMENT_SUCCESSFULLY = 2;
    const STATE_CANCELLED = 3;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bot_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month', 'bot_id'], 'required'],
            [['bot_id', 'user_id', 'month', 'amount', 'state', 'created_at'], 'integer'],
            [['coupon'], 'string', 'max' => 255],
            [['bot_id'], 'exist', 'skipOnError' => true, 'targetClass' => TelegramBot::className(), 'targetAttribute' => ['bot_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => Yii::t('app', 'User ID'),
            'month' => Yii::t('app', 'Month'),
            'amount' => Yii::t('app', 'Amount'),
            'state' => Yii::t('app', 'State'),
            'created_at' => Yii::t('app', 'Created At'),
            'coupon' => Yii::t('app', 'Coupon'),
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getStates()
    {
        return [
            self::STATE_WAITING_PAYMENT => t('Waiting Payment'),
            self::STATE_PAYMENT_SUCCESSFULLY => t('Payment Success'),
            self::STATE_CANCELLED => t('Cancelled'),
        ];
    }

    public function getStateLabel()
    {
        return self::getStates()[$this->state];
    }
}

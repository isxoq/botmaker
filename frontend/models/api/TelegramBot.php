<?php

namespace frontend\models\api;

use common\models\BaseActiveRecord;
use common\models\User;
use frontend\models\BotOrder;
use Yii;

/**
 * This is the model class for table "telegram_bot".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $token
 * @property string|null $bot_username
 * @property string|null $bot_id
 * @property string $type
 * @property string $typeName
 * @property string $statusName
 * @property string $name
 * @property string $webhook
 * @property int|null $status
 *
 * @property User $user
 */
class TelegramBot extends BaseActiveRecord
{

    const TYPE_ECOMMERCE = 1;

    const SCENARIO_CREATE = 'scenario_create';
    const SCENARIO_UPDATE = 'scenario_update';
    const SCENARIO_SETWEBHOOK = 'scenario_setwebhook';
    const SCENARIO_CHANGE_STATE = 'scenario_changestate';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_bot';
    }


    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['token', 'type', 'status'],
            self::SCENARIO_UPDATE => ['token', 'type', 'status'],
            self::SCENARIO_SETWEBHOOK => ['webhook'],
            self::SCENARIO_CHANGE_STATE => ['active_to'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'integer'],
            ['webhook', 'required'],
            [['type'], 'required'],
            [['token', 'bot_username', 'bot_id', 'type'], 'string', 'max' => 255],
            [['token'], 'unique'],
            [['name', 'webhook'], 'string'],
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
            'user_id' => Yii::t('app', 'User ID'),
            'token' => Yii::t('app', 'Token'),
            'name' => Yii::t('app', 'Name'),
            'bot_username' => Yii::t('app', 'Bot Username'),
            'bot_id' => Yii::t('app', 'Bot ID'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
        ];
    }


    public function getWebhook()
    {
        $bot = telegram_core([
            'token' => $this->token
        ]);

//        dd($bot->getWebhook());
        return $bot->getWebhook();
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

    /**
     * Tiplar
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::TYPE_ECOMMERCE => t('E Commerce')
        ];
    }

    /**
     * Tip nomi
     * @return array
     */
    public function getTypeName()
    {
        return self::getTypes()[$this->type];
    }

    public static function addPeriod($order_id)
    {
        $order = BotOrder::findOne($order_id);
        $bot = TelegramBot::findOne($order->bot_id);

        $bot->scenario = TelegramBot::SCENARIO_CHANGE_STATE;

        $bot->active_to += $order->month * 30 * 24 * 3600;
        $bot->save();

    }

}

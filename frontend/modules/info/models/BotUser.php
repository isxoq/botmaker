<?php

namespace frontend\modules\info\models;

use frontend\models\TelegramBot;
use Yii;

/**
 * This is the model class for table "bot_user".
 *
 * @property int $id
 * @property int|null $bot_id
 * @property string|null $user_id
 * @property string|null $username
 * @property string|null $phone
 * @property string|null $full_name
 * @property int|null $last_action_date
 * @property int|null $status
 *
 * @property TelegramBot $bot
 */
class BotUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bot_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bot_id', 'last_action_date', 'status'], 'integer'],
            [['user_id', 'username', 'phone', 'full_name'], 'string', 'max' => 255],
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
            'user_id' => Yii::t('app', 'User ID'),
            'username' => Yii::t('app', 'Username'),
            'phone' => Yii::t('app', 'S Phone'),
            'full_name' => Yii::t('app', 'Full Name'),
            'last_action_date' => Yii::t('app', 'Last Action Date'),
            'status' => Yii::t('app', 'Status'),
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

<?php

namespace frontend\models;

use common\models\User;
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
 * @property int|null $status
 *
 * @property User $user
 */
class TelegramBot extends \yii\db\ActiveRecord
{

    const TYPE_ECOMMERCE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_bot';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'integer'],
            [['type'], 'required'],
            [['token', 'bot_username', 'bot_id', 'type'], 'string', 'max' => 255],
            [['token'], 'unique'],
            ['name', 'string'],
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
            'bot_username' => Yii::t('app', 'Bot Username'),
            'bot_id' => Yii::t('app', 'Bot ID'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
        ];
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

    public static function getTypes()
    {
        return [
            self::TYPE_ECOMMERCE => t('E Commerce')
        ];
    }
}

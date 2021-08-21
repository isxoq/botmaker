<?php

namespace frontend\modules\ecommerce\models;

use frontend\models\TelegramBot;
use Yii;

/**
 * This is the model class for table "bot_post".
 *
 * @property int $id
 * @property int $bot_id
 * @property string|null $image
 * @property string|null $caption
 */
class BotPost extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bot_post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['bot_id', 'integer'],
            [['caption'], 'string'],
            [['image'], 'string', 'max' => 255],
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
            'image' => Yii::t('app', 'Image'),
            'caption' => Yii::t('app', 'Caption'),
        ];
    }

    public function getBot()
    {
        return $this->hasOne(TelegramBot::class, ['id' => 'bot_id']);
    }

    public static function find()
    {
        return parent::find()->joinWith('bot')->andWhere(['telegram_bot.id' => Yii::$app->controller->module->bot->id]);
    }

}

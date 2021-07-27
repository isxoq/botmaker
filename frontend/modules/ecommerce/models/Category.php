<?php

namespace frontend\modules\ecommerce\models;

use frontend\models\TelegramBot;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int|null $bot_id
 * @property int|null $parent_id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $order_id
 * @property string|null $image
 * @property int|null $status
 *
 * @property TelegramBot $bot
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bot_id', 'parent_id', 'order_id', 'status'], 'integer'],
            [['description'], 'string'],
            [['name', 'image'], 'string', 'max' => 255],
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
            'parent_id' => Yii::t('app', 'Parent ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'order_id' => Yii::t('app', 'Order ID'),
            'image' => Yii::t('app', 'Image'),
            'status' => Yii::t('app', 'Status'),
        ];
    }


    public function getParent()
    {
        return self::find()->andWhere(['parent_id' => $this->id]);
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

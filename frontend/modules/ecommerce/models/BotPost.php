<?php

namespace frontend\modules\ecommerce\models;

use Yii;

/**
 * This is the model class for table "bot_post".
 *
 * @property int $id
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
            'image' => Yii::t('app', 'Image'),
            'caption' => Yii::t('app', 'Caption'),
        ];
    }
}

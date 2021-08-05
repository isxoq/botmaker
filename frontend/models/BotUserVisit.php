<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "bot_user_visit".
 *
 * @property int $id
 * @property int|null $bot_id
 * @property int|null $bot_user_id
 * @property int|null $datetime
 * @property int|null $use_count
 */
class BotUserVisit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bot_user_visit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bot_id', 'bot_user_id', 'datetime', 'use_count'], 'integer'],
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
            'bot_user_id' => Yii::t('app', 'Bot User ID'),
            'datetime' => Yii::t('app', 'Datetime'),
            'use_count' => Yii::t('app', 'Use Count'),
        ];
    }
}

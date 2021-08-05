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

    public static function dayVisits($day)
    {
        $today_visit = self::find()
            ->andWhere(['bot_id' => Yii::$app->controller->module->bot->id,])
            ->andWhere(['between', 'datetime', strtotime($day['start']), strtotime($day['end'])])
            ->count();
        return $today_visit;
    }

    public static function visits()
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
        $visits = [];
        $days = array_reverse($days);

        foreach ($days as $day) {
            $visits[] = BotUserVisit::dayVisits($day);
        }

        $labels = json_encode(array_reverse($labels));
        $visits = json_encode($visits);
        return [
            'labels' => $labels,
            'visits' => $visits,
            'label' => t('Visits')
        ];
    }
}

<?php

namespace frontend\modules\ecommerce\controllers;

use frontend\models\BotUserVisit;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `ecommerce` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTrafficCartInfo($bot_id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

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

        return [
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => t('Visit'),
                        'borderColor' => "rgba(4, 73, 203,.09)",
                        'borderWidth' => "1",
                        'backgroundColor' => "rgba(4, 73, 203,.5)",
                        'data' => $visits,
                    ]
                ],
            ],
            'options' => [
                'responsive' => true,
                'tooltips' => [
                    'mode' => 'index',
                    'intersect' => false
                ],
                'hover' => [
                    'mode' => "nearest",
                    'intersect' => true
                ]
            ]
        ];

    }
}

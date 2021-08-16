<?php

/*
Project Name: botmaker.loc
File Name: BotSetting.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/13/2021 4:22 PM
*/

namespace frontend\modules\ecommerce\controllers;


use backend\modules\payme\paycom\Response;
use frontend\models\api\TelegramBot;
use yii\helpers\Url;

class BotSettingController extends \yii\web\Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionUpdateSetting()
    {

        $bot = TelegramBot::findOne(\Yii::$app->controller->module->bot->id);

        $bot->scenario = TelegramBot::SCENARIO_SETWEBHOOK;
        $bot->webhook = Url::to(['/ecommerce-api/hook', 'bot_id' => $bot->bot_id], true);
        $bot->save();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $token = \Yii::$app->request->post('botToken');
        $name = \Yii::$app->request->post('botName');

        $bot->scenario = TelegramBot::SCENARIO_UPDATE;
        $bot->token = $token;
        $bot->name = $name;
        $bot->save();

        $webhook = telegram_core([
            'token' => $bot->token,
            'data' => [
                'url' => $bot->webhook
            ]
        ])->setWebhook();

        return $webhook;

    }

}


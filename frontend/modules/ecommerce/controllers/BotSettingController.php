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
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

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

    public function actionUpdateSettingDelivery()
    {

        $bot = TelegramBot::findOne(\Yii::$app->controller->module->bot->id);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $delivery_price = \Yii::$app->request->post('delivery_price');
        $min_delivery_price = \Yii::$app->request->post('min_delivery_price');

        if (!is_numeric($delivery_price) || !is_numeric($min_delivery_price)) {

            \Yii::$app->response->statusCode = 400;
            return 0;

        }

        $bot->scenario = TelegramBot::SCENARIO_UPDATE_DELIVERY_PRICES;
        $bot->delivery_price = $delivery_price;
        $bot->min_order_price = $min_delivery_price;
        $bot->save();


        return $bot;

    }

    public function actionUpdateSettingAbout()
    {

        $bot = TelegramBot::findOne(\Yii::$app->controller->module->bot->id);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $bot->scenario = TelegramBot::SCENARIO_UPDATE_BOT_ABOUT;

        if ($about_image = UploadedFile::getInstanceByName('about_image')) {

            $filename = "uploads/bot/about/" . \Yii::$app->security->generateRandomString(25) . "." . $about_image->extension;
            $about_image->saveAs($filename);
            $bot->about_image = "/" . $filename;

        }

        $about_text = \Yii::$app->request->post('about_description');
        $bot->about_text = $about_text;
        $bot->save();

//        $bot->scenario = TelegramBot::SCENARIO_UPDATE_DELIVERY_PRICES;
//        $bot->delivery_price = $delivery_price;
//        $bot->min_order_price = $min_delivery_price;
//        $bot->save();


        return $bot;

    }

    public function actionDelete()
    {

        $this->enableCsrfValidation = false;
        $bot = TelegramBot::findOne(\Yii::$app->controller->module->bot->id);
        $bot->delete();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


        return [
            'deleted' => true
        ];

    }

}


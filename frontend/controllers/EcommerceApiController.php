<?php

namespace frontend\controllers;
/*
Project Name: botmaker.loc
File Name: EcommerceApi.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 7/30/2021 3:47 PM
*/

use frontend\models\TelegramBot;
use yii;

class EcommerceApiController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public $bot;
    public $bot_id;

    public function actionHook()
    {
        $raw = Yii::$app->request->rawBody;
        $update = yii\helpers\Json::decode($raw, false);
        $message = $update->message;
        $edited_message = $update->edited_message;
        $channel_post = $update->channel_post;
        $edited_channel_post = $update->edited_channel_post;
        $inline_query = $update->inline_query;
        $chosen_inline_result = $update->chosen_inline_result;
        $callback_query = $update->callback_query;





        $ttt = file_put_contents('sss.php', $php_body);

        $aa = telegram_core([
            'token' => "1010558826:AAH4ZxVGh6tcXR5Cyn_LxVadiaYQuIApFzc",
        ])->sendMessage([
            'text' => "sdcdsc",
            'chat_id' => $ttt
        ]);
//        $this->bot = TelegramBot::findOne(['bot_id' => $message->from->id]);

    }
}


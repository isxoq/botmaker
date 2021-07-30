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

class Bot1888365145Controller extends \yii\web\Controller
{
    public $enableCsrfValidation = false;          const BOT_TOKEN = "1888365145:AAHAyHLOgZyiCRRez7jnZHHejg6nWJi3UCo";

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


        try {
            $a = $this->telegram()->sendMessage([
                'text' => "Bot muvaffaqiyatli yaratildi va ulandi!",
                'chat_id' => $message->from->id
            ]);
        } catch (\Exception $e) {

            file_put_contents('err.txt', $e->getMessage());
        }


//        $this->bot = TelegramBot::findOne(['bot_id' => $message->from->id]);

    }

    protected function telegram(): \common\components\TelegramApi
    {
        return new \common\components\TelegramApi([
            'token' => self::BOT_TOKEN,
        ]);
    }

}
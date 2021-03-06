<?php

namespace common\components;
/*
Project Name: botmaker.loc
File Name: TelegramApi.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 7/26/2021 3:31 PM
*/

use yii\helpers\Json;

class TelegramApi extends \yii\base\Component
{

    public $token = "";
    public $data = [];

    public function __construct($config = [])
    {
        $this->token = $config['token'];
        $this->data = $config['data'];

    }

    public function editMessageText($data)
    {
        return $this->request('editMessageText', $data);
    }

    public function editMessageReplyMarkup($data)
    {
        return $this->request('editMessageReplyMarkup', $data);
    }

    public function answerCallback($data)
    {
        return $this->request('answerCallbackQuery', $data);
    }

    public function sendMessage($data)
    {
        return $this->request('sendMessage', $data);
    }

    public function deleteMessage($data)
    {
        return $this->request('deleteMessage', $data);
    }

    public function sendPhoto($data)
    {
        return $this->request('sendPhoto', $data);
    }

    public function getMe()
    {
        return $this->request("getMe", null);
    }

    public function getWebhook()
    {
        return $this->request("getWebhookInfo", null);
    }

    public function setWebhook()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.telegram.org/bot' . $this->token . '/setWebhook?url=' . $this->data['url'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return Json::decode($response, false);

    }


    protected function request($method, $data)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.telegram.org/bot' . $this->token . '/' . $method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data
        ));


        $response = curl_exec($curl);

        curl_close($curl);

        if (!is_null($response)) {

            return \yii\helpers\Json::decode($response, false);
        } else {
            return \yii\helpers\Json::decode("{}", false);
        }

    }
}
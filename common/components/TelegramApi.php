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
        if (isset($config['data'])) {
            $this->data = $config['data'];
        }
    }


    public function getMe()
    {
        return $this->request($method = "getMe");
    }

    public function getWebhook()
    {
        return $this->request($method = "getWebhookInfo");
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


    protected function request($method)
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
            CURLOPT_POSTFIELDS => \yii\helpers\Json::encode($this->data)
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return \yii\helpers\Json::decode($response, false);

    }
}
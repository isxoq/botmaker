<?php

namespace backend\modules\eskizsms\components;

use yii\base\Component;
use yii\helpers\Html;

class SendEskizSms extends Component
{

    public static function SendSms($phone, $text)
    {

        $sms = \backend\modules\eskizsms\models\EskizSms::find()->one();

        $phone = str_replace('+', '', $phone);
        $phone = str_replace(' ', '', $phone);
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(')', '', $phone);
        $phone = str_replace('-', '', $phone);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'notify.eskiz.uz/api/message/sms/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('mobile_phone' => $phone, 'message' => trim($text), 'from' => '4546'),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer {$sms->key}"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
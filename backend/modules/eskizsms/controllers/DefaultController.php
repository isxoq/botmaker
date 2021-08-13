<?php

namespace backend\modules\eskizsms\controllers;

use backend\modules\eskizsms\components\SendEskizSms;
use backend\modules\eskizsms\models\EskizSms;
use yii\helpers\Json;
use yii\web\Controller;

/**
 * Default controller for the `eskizsms` module
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

    public function actionUpdate()
    {

        $model = EskizSms::find()->one();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            $this->redirect(['default/index']);
        }
        return $this->render('update', compact('model'));
    }

    public function actionUpdateToken()
    {
        $model = EskizSms::find()->one();

        if ($model->key) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'notify.eskiz.uz/api/auth/refresh',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'PATCH',
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer {$model->key}"
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $response = Json::decode($response, false);

            if ($response->data->token) {

                $model->key = $response->data->token;
                $model->save();
                return $this->redirect(['default/index']);

            }
        } else {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'notify.eskiz.uz/api/auth/login',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('email' => $model->username, 'password' => $model->password),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $response = Json::decode($response, false);

            if ($response->data->token) {
                $model->key = $response->data->token;
                $model->save();
                return $this->redirect(['default/index']);

            }

        }

    }

    public function actionTest()
    {
        return SendEskizSms::SendSms('+998907805777', 'salom');
    }
}

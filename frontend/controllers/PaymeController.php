<?php

namespace frontend\controllers;
/*
Project Name: kontrol.loc
File Name: PaymeController.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/6/2021 2:24 PM
*/

use yii;
use backend\modules\payme\components\Wallet;
use yii\web\Response;
use yii\web\Controller;
use backend\modules\payme\paycom\Application;

class PaymeController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionPayme()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $application = new Application(Yii::$app->params['paycomConfig']);
        return $application->run();


    }
}

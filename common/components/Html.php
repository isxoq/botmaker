<?php

namespace common\components;

use yii;

/*
Project Name: botmaker.loc
File Name: Html.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 7/27/2021 4:45 PM
*/

class Html extends \yii\helpers\Html
{
    public static function a($text, $url = null, $options = [])
    {
        $url['bot_id'] = Yii::$app->request->get('bot_id');
        return parent::a($text, $url, $options);
    }
}
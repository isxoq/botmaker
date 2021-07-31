<?php


/**
 * Tarjima qilish uchun
 *
 * @param $word
 * @return string
 */
function t($word, $params = [])
{
    return Yii::t('app', $word, $params);
}


/**
 * Telefon raqamni tozalaydi
 *
 * @param $phone
 * @return string
 */
function clearPhone($phone)
{
    $phone = str_replace('+', "", $phone);
    $phone = str_replace(' ', "", $phone);
    $phone = str_replace('(', "", $phone);
    $phone = str_replace(')', "", $phone);
    return str_replace('-', "", $phone);
}

/**
 * @throws \yii\web\NotFoundHttpException
 */
function notFound()
{
    throw new \yii\web\NotFoundHttpException();
}

/**
 * @param array $config
 */
function telegram_core($config = []): \common\components\TelegramApi
{
    return new common\components\TelegramApi([
        'token' => $config['token'],
        'data' => $config['data'],
    ]);
}


function user(): ?\common\models\User
{
    return \common\models\User::findOne(Yii::$app->user->id);
}

?>
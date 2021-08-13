<?php


$sms = \backend\modules\eskizsms\models\EskizSms::find()->one();

?>

<div class="eskizsms-default-index">
    <h3><?= $sms->username ?></h3>
    <h3> ********** </h3>
    <h3>Token: <?= substr($sms->key, 0, 15) ?></h3>
    <hr>
    <?= \yii\helpers\Html::a(t('update'), \yii\helpers\Url::to(['default/update'], true), [
        'class' => 'btn btn-primary'
    ]) ?>

    <?= \yii\helpers\Html::a(t('update token'), \yii\helpers\Url::to(['default/update-token'], true), [
        'class' => 'btn btn-warning'
    ]) ?>
</div>

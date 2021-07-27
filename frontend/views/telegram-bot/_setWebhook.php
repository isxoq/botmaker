<?php
/*
Project Name: botmaker.loc
File Name: _setWebhook.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 7/27/2021 10:37 AM
*/

/* @var $this yii\web\View */
/* @var $model frontend\models\TelegramBot */

/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Set webhook');


?>

<h1><?= \yii\helpers\Html::encode($this->title) ?></h1>

<hr>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'webhook')->textInput(['maxlength' => true]) ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>


<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = t("Kirish | Ro'yhatdan o'tish");
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="sufee-login d-flex align-content-center flex-wrap">
    <div class="container">
        <div class="login-content">
            <div class="login-logo">
                <a href="index.html">
                    <h3><?= $this->title ?></h3>
                </a>
            </div>
            <div class="login-form">


                <center>
                    <script async src="https://telegram.org/js/telegram-widget.js?15" data-telegram-login="botyasabot" data-size="large" data-auth-url="https://botmaker.loc/site/login-via-telegram"></script>
                </center>

                <br>
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>


                <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
                    'mask' => '+\9\98(99) 999-99-99',
                ]); ?>

                <?= Html::submitButton('Login | Register', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
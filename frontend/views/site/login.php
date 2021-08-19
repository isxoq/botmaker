<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Login');
?>

<div class="sufee-login d-flex align-content-center flex-wrap">
    <div class="container">
        <div class="login-content">
            <div class="login-logo">
                <a href="index.html">
                    <h3><?= $this->title ?></h3>
                    <!--                    <img class="align-content" src="/images/logo.png" alt="">-->
                </a>
            </div>
            <div class="login-form">

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>

                <div class="register-link m-t-15 text-center">
                    <p><?= Yii::t('app', "Don't have account ?") ?> <a
                                href="<?= \yii\helpers\Url::to(['site/signup']) ?>"><?= Yii::t('app', 'Sign Up Here') ?></a>
                    </p>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
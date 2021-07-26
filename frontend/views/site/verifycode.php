<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = t("Kodni tasdiqlash");
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
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->errorSummary($model) ?>

                <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
                    'mask' => '+\9\98(99) 999-99-99',
                    'options' => [
                        'readOnly' => true
                    ]
                ]); ?>
                <?= $form->field($model, 'verify_code')->textInput(); ?>

                <?= Html::submitButton('Tasdiqlash', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
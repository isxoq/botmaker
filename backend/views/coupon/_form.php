<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Coupon */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="coupon-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'user_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username'), [
                'prompt' => ""
            ]) ?>

            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'amount')->textInput() ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'active_to')->textInput([
                'type' => 'date'
            ]) ?>

            <?= $form->field($model, 'use_count')->textInput() ?>

            <?= $form->field($model, 'status')->dropDownList([
                1 => t("Active"),
                0 => t("In Active"),
            ]) ?>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

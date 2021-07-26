<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\TelegramBot */
/* @var $form yii\widgets\ActiveForm */
?>
    <hr>
    <div class="telegram-bot-form">

        <div class="container">
            <diw class="row">
                <div class="col-md-6">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'token')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'type')->dropDownList(\frontend\models\TelegramBot::getTypes()) ?>

                    <?= $form->field($model, 'status')->dropDownList([

                        1 => t("Enabled"),
                        2 => t("Disabled"),

                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
                <div class="col-md-6">
                    <h3>Bot nomi</h3>
                </div>
            </diw>
        </div>

    </div>
<?php
$this->registerJs(
    <<<JS
$('#telegrambot-token').on('keyup',function() {
  alert("salom")
})
JS

)
?>
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

                    <?= $form->errorSummary($model); ?>

                    <?= $form->field($model, 'token')->textInput(['maxlength' => true, 'data-href' => \yii\helpers\Url::to(['telegram-bot/get-me'], true)]) ?>
                    <a style="font-size: 11px; top: 71px!important;    position: absolute;" class="bot-link" href=""
                       id="bot_name"><b
                                id="bot_username"></b></a>
                    <?= $form->field($model, 'type')->dropDownList(\frontend\models\TelegramBot::getTypes()) ?>

                    <?= $form->field($model, 'status')->dropDownList([

                        1 => t("Enabled"),
                        0 => t("Disabled"),

                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>

                <div class="col-md-6">
                    <div class="row">
                        <p><?=t('Bot Create Help')?></p>
                    </div>
                </div>
            </diw>
        </div>

    </div>
<?php
$this->registerJs(
    <<<JS
$('#telegrambot-token').on('keyup',function() {
  $.ajax({
    'url':$(this).attr('data-href'),
    'type':"POST",
    'data':{
        'token':$(this).val()
    },
    'success':function(data) {
      $('#bot_name').text(data.result.first_name)
      $('.bot-link').attr('href',data.result.username)
      $('#bot_username').text(data.result.username)
    }
  })
})
JS

)
?>
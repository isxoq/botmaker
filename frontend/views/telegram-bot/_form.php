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

                    <?= $form->field($model, 'token')->textInput(['maxlength' => true, 'data-href' => \yii\helpers\Url::to(['telegram-bot/get-me'], true)]) ?>

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
                    <p><?= t('Bot nomi') ?> <b id="bot_name"></b></p>
                    <p><?= t('Bot foydalanuvchi nomi') ?> <b id="bot_username"></b></p>
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
    'succes':function(data) {
      console.log(data)
      $('#bot_name').text(data.result.first_name)
      $('#bot_username').text(data.result.username)
    }
  })
})
JS

)
?>
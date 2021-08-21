<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\BotOrder */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="bot-order-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-6">

                <?= $form->field($model, 'bot_id')->dropDownList(\yii\helpers\ArrayHelper::map(\frontend\models\api\TelegramBot::find()->andWhere(['user_id' => Yii::$app->user->id])->all(), 'id', 'name')) ?>

                <?= $form->field($model, 'month')->dropDownList([
                    1 => t('1 month'),
                    2 => t('2 month'),
                    3 => t('3 month'),
                    4 => t('4 month'),
                    5 => t('5 month'),
                    6 => t('6 month'),
                    7 => t('7 month'),
                    8 => t('8 month'),
                    9 => t('9 month'),
                    10 => t('10 month'),
                    11 => t('11 month'),
                    12 => t('12 month'),
                    24 => t('24 month'),
                ], [
                    'prompt' => t('Select')
                ]) ?>


            </div>

            <div class="col-md-6">

                <?= $form->field($model, 'coupon')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'amount')->textInput([
                    'readOnly' => true
                ]) ?>
                <div id="sale_block"></div>


            </div>
        </div>


        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


<?php

$saleLabel = t(' chegirma');

$url = "'" . \yii\helpers\Url::to(['bot-order/get-amount'], true) . "'";
$js = <<<JS
        $(document).on('change','#botorder-month',function() {
                                 $('#sale_block').addClass('hide')

            let month = $(this).val()
            let bot_id = $('#botorder-bot_id').val()
            
            $.ajax({
                url:$url,
                type:"POST",
                data:{
                    bot_id:bot_id,
                    month:month
                },
                success:function (data) {
                  $('#botorder-amount').val(data.total)
                  
                  if (data.sale>0){
                      $('#sale_block').removeClass('hide')
                      $('#sale_block').html(data.sale+"% "+"( UZS "+data.salePrice+") <span>UZS <strike>"+data.oldPrice+"</strike></span>")
                  }
                }
            })  
             
             
        })  
JS;
$this->registerJs($js);
?>
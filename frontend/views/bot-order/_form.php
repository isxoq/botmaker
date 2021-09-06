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

                <?= $form->field($model, 'month')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\models\BotPriceTable::find()->all(), 'month', 'month'), [
                    'prompt' => t('Select')
                ]) ?>


            </div>

            <div class="col-md-6">

                <?= $form->field($model, 'coupon')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'amount')->textInput([
                    'readOnly' => true
                ]) ?>
                <div class="d-none" id="sale_block"></div>


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

         function updateBotOrder(bot_id,month,coupon) {
                         $.ajax({
                            url:$url,
                            type:"POST",
                            data:{
                                bot_id:bot_id,
                                month:month,
                                coupon:coupon
                            },
                            success:function (data) {
                              $('#botorder-amount').val(data.total)
                              
                              if (data.sale>0){
                                  $('#sale_block').removeClass('d-none')
                                  $('#sale_block').html("-"+data.sale+"% {$saleLabel} "+"( UZS "+data.salePrice+") <span>UZS <strike>"+data.oldPrice+"</strike></span>")
                              }else{
                                                                   $('#sale_block').addClass('d-none')
                              }
                            }
                        })  
                    }
        $(document).on('change','#botorder-month',function() {

            
            let month = $(this).val()
            let bot_id = $('#botorder-bot_id').val()
            let coupon = $('#botorder-coupon').val()
            
           updateBotOrder(bot_id,month,coupon)
           
             
        })  
JS;
$this->registerJs($js);
?>
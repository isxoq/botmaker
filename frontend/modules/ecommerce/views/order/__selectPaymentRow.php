<?php
/*
Project Name: botmaker.loc
File Name: __selectRow.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/4/2021 4:18 PM
*/

$statuses = \frontend\models\api\Order::getOrderPaymentStatuses();
?>

<select name="" data-bot-id="" data-id="<?= $model->id ?>"
        class="payment_status_dropdown"
        data-url="<?= \yii\helpers\Url::to(['order/change-payment-status', 'bot_id' => Yii::$app->controller->module->bot->id], true) ?>">
    <?php foreach ($statuses as $key => $value): ?>
        <option value="<?= $key ?>" <?= $model->payment_status == $key ? "selected" : "" ?>><?= $value ?></option>
    <?php endforeach ?>
</select>

<?php

$this->registerJs(
    <<<JS
        $('.payment_status_dropdown').on('change',function(e) {
          let order_id = $(this).attr('data-id')
          let value = $(this).val()
          let url = $(this).attr('data-url')
          $.ajax({
            "url":url,
            'type':"POST",
            'data':{
                "order_id":order_id,
                "status":value
            },
            "success":function(data) {
              console.log(data)
            }
          })
        })
JS

);

?>

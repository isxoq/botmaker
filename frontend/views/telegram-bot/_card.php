<?php
/*
Project Name: botmaker.loc
File Name: _card.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 7/26/2021 2:41 PM
*/

/**
 * @var \frontend\models\TelegramBot $model
 */


?>
<div class="card-header">
    <strong class="card-title pl-2"><?= $model->name ?></strong>
</div>
<div class="card-body">
    <a href="<?= \yii\helpers\Url::to(['/ecommerce/default/index', 'bot_id' => $model->id]) ?>">
        <div class="mx-auto d-block">
            <h5 class="text-sm-center mt-2 mb-1"><b>ID: </b><?= $model->bot_id ?></h5>
            <div class="location text-sm-center"><b><?= t('Turi') ?></b> <?= $model->typeName ?></div>
            <div class="location text-sm-center"><b><?= t('Status') ?></b> <?= $model->statusName ?></div>
            <?php if ($model->webhook): ?>
                <div class="location text-sm-center"><b
                            class="text-success"><?= t('Webhook faol') ?></b> <?= $model->webhook ?> <?= \yii\helpers\Html::a("<i class='fa fa-edit'></i>", ['telegram-bot/set-webhook', 'id' => $model->id]) ?>
                </div>
            <?php else: ?>
                <div class="location text-sm-center">  <?= \yii\helpers\Html::a(t('Webhook sozlash'), ['telegram-bot/set-webhook', 'id' => $model->id]) ?></div>
            <?php endif; ?>
        </div>
    </a>
    <hr>
    <?= \yii\helpers\Html::a("<i class='fa fa-eye'></i>", ['telegram-bot/view', 'id' => $model->id]) ?>
    <?= \yii\helpers\Html::a("<i class='fa fa-edit'></i>", ['telegram-bot/update', 'id' => $model->id]) ?>
    <?= \yii\helpers\Html::a("<i class='fa fa-trash'></i>", ['telegram-bot/delete', 'id' => $model->id], ['data' => ['method' => "post"]]) ?>
</div>

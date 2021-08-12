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
 */;

?>
<a href="<?= \yii\helpers\Url::to(['/ecommerce/default/index', 'bot_id' => $model->id]) ?>">
    <div class="card-header">
        <strong class="card-title pl-2"><?= $model->name ?></strong>
    </div>
    <div class="card-body">
        <div class="mx-auto d-block">
            <h5 class=" mt-2 mb-1"><b>ID: </b><?= $model->bot_id ?></h5>
            <div class="location "><b><?= t('Turi') ?></b> <?= $model->typeName ?></div>
            <div class="location "><b><?= t('Status') ?></b> <?= $model->statusName ?></div>
            <div class="location ">
                <b><?= t('Users') ?></b> <?= \frontend\models\api\BotUser::find()->andWhere(['bot_id' => $model->id])->count() ?>
            </div>

        </div>
        <hr>
        <?= $model->availableDays ?>
        <?= $model->isAvailable ? t('Faol holatda') : t('Puli tugagan') ?>
    </div>
</a>

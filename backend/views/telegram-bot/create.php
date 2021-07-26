<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TelegramBot */

$this->title = Yii::t('app', 'Create Telegram Bot');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Telegram Bots'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="telegram-bot-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

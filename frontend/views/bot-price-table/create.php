<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BotPriceTable */

$this->title = Yii::t('app', 'Create Bot Price Table');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bot Price Tables'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bot-price-table-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

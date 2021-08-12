<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\BotOrder */

$this->title = Yii::t('app', 'Create Bot Order');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bot Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bot-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

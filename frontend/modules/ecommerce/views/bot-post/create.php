<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\ecommerce\models\BotPost */

$this->title = Yii::t('app', 'Create Bot Post');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bot Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bot-post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

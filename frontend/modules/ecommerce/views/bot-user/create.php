<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\ecommerce\models\BotUser */

$this->title = Yii::t('app', 'Create Bot User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bot Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bot-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

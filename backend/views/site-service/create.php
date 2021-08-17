<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SiteService */

$this->title = Yii::t('app', 'Create Site Service');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Site Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-service-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

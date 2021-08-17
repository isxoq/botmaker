<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SiteFeatureImage */

$this->title = Yii::t('app', 'Create Site Feature Image');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Site Feature Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-feature-image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

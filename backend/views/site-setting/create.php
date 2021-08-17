<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SiteSetting */

$this->title = Yii::t('app', 'Create Site Setting');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Site Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

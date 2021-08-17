<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SiteAppClips */

$this->title = Yii::t('app', 'Create Site App Clips');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Site App Clips'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-app-clips-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

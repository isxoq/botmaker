<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SiteFeature */

$this->title = Yii::t('app', 'Create Site Feature');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Site Features'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-feature-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

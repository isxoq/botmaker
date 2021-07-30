<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\ecommerce\models\ProductVariant */
/* @var $product \frontend\modules\ecommerce\models\Product */


$this->title = Yii::t('app', 'Create Product Variant');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Variants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-variant-create">

    <h1><?= Html::encode($this->title) ?>: <?= $product->name ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

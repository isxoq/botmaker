<?php

use common\components\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\ecommerce\models\search\ProductVariantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $product \frontend\modules\ecommerce\models\Product */

$this->title = Yii::t('app', 'Product Variants');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="animated fadeIn">
    <div class="card">
        <div class="card-header">
            <strong class="card-title"><?= Html::encode($this->title) ?></strong>
            <?= Html::a("<i class='fa fa-plus'></i>", ['create', 'product_id' => Yii::$app->request->get('product_id')], ['class' => 'btn btn-success']) ?>
            <?= Html::a("<i class='fa fa-reply'></i>", ['/ecommerce/product/index'], ['class' => 'btn btn-warning']) ?>
        </div>
        <div class="table-stats order-table ov-h">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'pager' => [
                    'linkContainerOptions' => [
                        'class' => 'page-item'
                    ],
                    'linkOptions' => [
                        'class' => 'page-link'
                    ],
                    'prevPageLabel' => "<a href='#'>&laquo;</a>"
                ],
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'product_id',
                    'name',
                    'old_price',
                    'price',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

            <?php Pjax::end(); ?>

        </div> <!-- /.table-stats -->
    </div>
</div>

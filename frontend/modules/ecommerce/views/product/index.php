<?php

use common\components\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\ecommerce\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="animated fadeIn">
    <div class="card">
        <div class="card-header">
            <strong class="card-title"><?= Html::encode($this->title) ?></strong>
            <?= Html::a("<i class='fa fa-plus'></i>", ['create'], ['class' => 'btn btn-success']) ?>
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
                    'name',
                    'category_id',
                    'old_price',
                    'price',
                    [
                        'attribute' => 'product_variant',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a("<i class='fa fa-eye'></i>", ['/ecommerce/product-variant/index', 'product_id' => $model->id], ['class' => 'btn-sm btn-warning']);
                        }
                    ],
                    //'image',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ['style' => 'width:130px'],
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a("<i class='fa fa-eye'></i>", ['view', 'id' => $model->id], ['class' => 'btn-sm btn-success']);
                            },

                            'update' => function ($url, $model) {
                                return Html::a("<i class='fa fa-edit'></i>", ['update', 'id' => $model->id], ['class' => 'btn-sm btn-primary']);
                            },

                            'delete' => function ($url, $model) {
                                return Html::a("<i class='fa fa-trash'></i>", ['delete', 'id' => $model->id], ['class' => 'btn-sm btn-danger',
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete?'),
                                    'data-method' => 'post', 'data-pjax' => '0',
                                ]);
                            },

                        ]
                    ],
                ],
                'tableOptions' => [
                    'class' => 'table'
                ],
                'layout' => '{items}{pager}{summary}'

            ]); ?>

            <?php Pjax::end(); ?>

        </div> <!-- /.table-stats -->
    </div>
</div>

<?php

use common\components\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\ecommerce\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
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
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
                    'created_at:datetime',
                    'user.full_name',
                    'orderStatus' => [
                        'attribute' => 'orderStatus',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $this->render('__selectRow', [
                                'model' => $model
                            ]);
                        }
                    ],
                    'total_price:integer',
                    'orderPaymentStatus' => [
                        'attribute' => 'orderPaymentStatus',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $this->render('__selectPaymentRow', [
                                'model' => $model
                            ]);
                        }
                    ],
                    //'payment_type',
                    //'comment:ntext',

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

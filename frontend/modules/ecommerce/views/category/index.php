<?php

use common\components\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\ecommerce\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
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

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
//                    'bot_id',
                    t('Ota kategoriya') => 'parent.name',
                    'name',
                    'description:ntext',
                    //'order_id',
//                    'image',
                    'status',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ['style' => 'width:130px'],
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a("<i class='fa fa-eye'></i>", ['create', 'id' => $model->id], ['class' => 'btn-sm btn-success']);
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

        </div> <!-- /.table-stats -->
    </div>
</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\BotOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bot Orders');
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

                    'id',
                    'bot.name',
//                    'user_id',
                    'month',
                    'amount',
                    'stateLabel',
                    [
                        'class' => 'yii\grid\ActionColumn',
//                        'headerOptions' => ['style' => 'width:270px'],
                        'template' => '{pay_click}',
                        'buttons' => [
                            'pay_click' => function ($url, $model) {
                                if ($model->state == \frontend\models\BotOrder::STATE_WAITING_PAYMENT) {
                                    return \backend\modules\click\widgets\ClickButtonWidget::widget([
                                        'order_id' => $model->id,
                                        'amount' => $model->amount,
                                        'title' => t('Pay Click'),
                                        'class' => 'btn-sm btn-primary'
                                    ]);
                                }

                            },
                        ]
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
//                        'headerOptions' => ['style' => 'width:270px'],
                        'template' => '{pay_click}',
                        'buttons' => [
                            'pay_click' => function ($url, $model) {
                                if ($model->state == \frontend\models\BotOrder::STATE_WAITING_PAYMENT) {

                                    return \backend\modules\payme\components\PaymeButton::widget([
                                        'order_id' => $model->id,
                                        'amount' => $model->amount,
                                        'title' => t('Pay Payme'),
                                        'class' => 'btn-sm btn-primary'
                                    ]);
                                }
                            },
                        ]
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ['style' => 'width:270px'],
                        'template' => '{view} {update} {delete}',

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

        </div> <!-- /.table-stats -->
    </div>
</div>
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TelegramBotSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Telegram Bots');
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
                    'user_id',
                    'token',
                    'bot_username',
                    'bot_id',
                    //'type',
                    //'status',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ['style' => 'width:130px'],
                        'icons' => [
                            'eye-open' => Html::a("<i class='fa fa-eye'></i>", ['create'], ['class' => 'btn-sm btn-success']),
                            'pencil' => Html::a("<i class='fa fa-edit'></i>", ['create'], ['class' => 'btn-sm btn-primary']),
                            'trash' => Html::a("<i class='fa fa-trash'></i>", ['create'], ['class' => 'btn-sm btn-danger']),

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
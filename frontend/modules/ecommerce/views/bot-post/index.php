<?php

use common\components\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\ecommerce\models\BotPostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bot Posts');
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
                        'image:image',
                        'caption:ntext',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['style' => 'width:170px'],
                            'template' => '{send}  {view} {update} {delete}',
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
                                'send' => function ($url, $model) {
                                    return Html::a("<i class='fa fa-send'></i>", ['send-post', 'id' => $model->id], ['class' => 'sendpostbutton btn-sm btn-warning',

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
<?php

$this->registerJs(
    <<<JS
$(document).on('click','.sendpostbutton',function(e) {
    e.preventDefault()
    var r = confirm("Press a button!");
    if (r == true) {
      $.ajax({
        'url':$(this).attr('href'),
        'type':"POST"
      })
    } else {
      txt = "You pressed Cancel!";
    }
})
JS
)

?>
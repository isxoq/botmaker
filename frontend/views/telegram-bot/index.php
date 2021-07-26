<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\TelegramBotSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Telegram Bots');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="telegram-bot-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>
    <?php Pjax::begin(); ?>


    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'class' => "row"
        ],
        'summary' => false,
        'itemOptions' => ['class' => 'card col-md-2 ml-4'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_card', ['model' => $model]);
        },
    ]) ?>


    <?php Pjax::end(); ?>


    <p>
        <?= Html::a(Yii::t('app', 'Create Telegram Bot'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

</div>

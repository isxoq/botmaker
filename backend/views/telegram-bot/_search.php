<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\TelegramBotSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="container">

    <div class="row">
        <div class="col-md-8">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'options' => [
                    'data-pjax' => 1
                ],
            ]); ?>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'bot_username') ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'bot_id') ?>
                </div>

                <div class="col-md-3">

                    <div class="row" style="margin-top: 31px">
                        <div class="col-md-6">
                            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <?php ActiveForm::end(); ?>
    </div>
</div>

</div>

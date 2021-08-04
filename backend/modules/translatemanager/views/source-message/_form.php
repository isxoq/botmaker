<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\translatemanager\models\SourceMessage */
/* @var $form yii\widgets\ActiveForm */

$languages = Yii::$app->controller->module->languages;
$messages = $model->messages;
?>


<div class="source-message-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'message')->textInput() ?>

    <?php if ($messages): ?>
        <?php foreach ($messages as $message): ?>
            <?= $form->field($model, 'languages[' . $message->language . ']')->textarea(['rows' => 6, 'value' => $message->translation])->label($message->language) ?>
        <?php endforeach; ?>

    <?php else: ?>
        <?php foreach ($languages as $language): ?>
            <?= $form->field($model, 'languages[' . $language . ']')->textarea(['rows' => 6])->label($language) ?>
        <?php endforeach; ?>

    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

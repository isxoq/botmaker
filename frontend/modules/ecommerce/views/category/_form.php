<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\ecommerce\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')->dropDownList(\yii\helpers\ArrayHelper::map(\frontend\modules\ecommerce\models\Category::find()->all(), 'id', 'name'), [
        'prompt' => ""
    ]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <?php echo $form->field($model, 'image')->widget(\mihaildev\elfinder\InputFile::className(), [
        'language' => 'ru',
        'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'path' => 'category', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
        'filter' => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options' => ['class' => 'form-control'],
        'buttonOptions' => ['class' => 'btn btn-primary'],
        'multiple' => false       // возможность выбора нескольких файлов
    ]); ?>

    <?= $form->field($model, 'status')->dropDownList([

        1 => t("Enabled"),
        0 => t("Disabled"),

    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

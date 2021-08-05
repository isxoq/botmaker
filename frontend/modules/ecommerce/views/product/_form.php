<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \frontend\modules\ecommerce\models\Product;

/* @var $this yii\web\View */
/* @var $model frontend\modules\ecommerce\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(\yii\helpers\ArrayHelper::map(\frontend\modules\ecommerce\models\Category::find()->all(), 'id', 'name'), [
        'prompt' => ""
    ]) ?>
    <?= $form->field($model, 'product_type')->dropDownList([
        Product::TYPE_COUNTABLE => t('Countable'),
        Product::TYPE_DIGITAL => t('Digital Product'),
    ]) ?>

    <diw class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'old_price')->textInput(['type' => 'number']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'price')->textInput(['type' => 'number']) ?>
        </div>
    </diw>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'image')->widget(\mihaildev\elfinder\InputFile::className(), ['language' => 'ru',
        'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'path' => 'product', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
        'filter' => 'image/jpeg',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options' => ['class' => 'form-control'],
        'buttonOptions' => ['class' => 'btn btn-primary'],
        'multiple' => false       // возможность выбора нескольких файлов
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

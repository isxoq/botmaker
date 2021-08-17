<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SiteFeatureImage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="site-feature-image-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'image')->widget(\mihaildev\elfinder\InputFile::className(), ['language' => 'ru',
        'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'path' => 'features', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
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

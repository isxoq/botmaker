<?php

namespace backend\modules\translatemanager;

/**
 * translatemanager module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */

    public $languages = ['uz', 'ru'];
    public $controllerNamespace = 'backend\modules\translatemanager\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

}

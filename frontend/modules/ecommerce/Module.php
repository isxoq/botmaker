<?php

namespace frontend\modules\ecommerce;

use frontend\models\TelegramBot;

/**
 * ecommerce module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\ecommerce\controllers';

    public $layout = 'main';

    public $bot = "";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $bot_id = \Yii::$app->request->get('bot_id');
        if ($bot_id) {
            $this->bot = TelegramBot::findOne($bot_id);
            if (!$this->bot) {
                notFound();
            }
        } else {
            notFound();
        }

        // custom initialization code goes here
    }
}

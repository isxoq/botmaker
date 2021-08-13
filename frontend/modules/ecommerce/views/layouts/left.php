<!-- Left Panel -->
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">

                <li class="<?= Yii::$app->controller->route == "/site/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['/site/index']) ?>"><i
                                class="menu-icon fa fa-reply"></i><?= Yii::t('app', 'Bosh sahifa') ?> </a>
                </li>
                <li class="<?= Yii::$app->controller->route == "ecommerce/default/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['/ecommerce/default/index', 'bot_id' => Yii::$app->controller->module->bot->id]) ?>"><i
                                class="menu-icon fa fa-laptop"></i><?= Yii::t('app', 'Dashboard') ?> </a>
                </li>

                <li class="<?= Yii::$app->controller->route == "/ecommerce/category/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['/ecommerce/category/index', 'bot_id' => Yii::$app->request->get('bot_id')]) ?>"><i
                                class="menu-icon fa fa-list"></i><?= Yii::t('app', 'Kategoriyalar') ?>
                    </a>
                </li>
                <li class="<?= Yii::$app->controller->route == "/ecommerce/product/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['/ecommerce/product/index', 'bot_id' => Yii::$app->request->get('bot_id')]) ?>"><i
                                class="menu-icon fa fa-list"></i><?= Yii::t('app', 'Mahsulotlar') ?>
                    </a>
                </li>

                <li class="<?= Yii::$app->controller->route == "/ecommerce/order/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['/ecommerce/order/index', 'bot_id' => Yii::$app->request->get('bot_id')]) ?>"><i
                                class="menu-icon fa fa-list"></i><?= Yii::t('app', 'Buyurtmalar') ?>
                    </a>
                </li>

                <li class="<?= Yii::$app->controller->route == "/ecommerce/bot-user/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['/ecommerce/bot-user/index', 'bot_id' => Yii::$app->request->get('bot_id')]) ?>"><i
                                class="menu-icon fa fa-list"></i><?= Yii::t('app', 'Foydalanuvchilar') ?>
                    </a>
                </li>

                <li class="<?= Yii::$app->controller->route == "ecommerce/bot-post" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['/ecommerce/bot-post', 'bot_id' => Yii::$app->request->get('bot_id')]) ?>"><i
                                class="menu-icon fa fa-list"></i><?= Yii::t('app', 'Posting') ?>
                    </a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
<!-- /#left-panel -->
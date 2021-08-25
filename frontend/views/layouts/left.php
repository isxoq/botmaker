<!-- Left Panel -->
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="<?= Yii::$app->controller->route == "site/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['site/index']) ?>"><i
                                class="menu-icon fa fa-laptop"></i><?= Yii::t('app', 'Dashboard') ?> </a>
                </li>
                <li class="<?= Yii::$app->controller->route == "telegram-bot/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['telegram-bot/index']) ?>"><i
                                class="menu-icon fa fa-list"></i><?= Yii::t('app', 'Telegram Bots') ?>
                    </a>
                </li>
                <li class="<?= Yii::$app->controller->route == "bot-order/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['bot-order/index']) ?>"><i
                                class="menu-icon fa fa-list"></i><?= Yii::t('app', 'Bot Order') ?>
                    </a>
                </li>

                <li class="<?= Yii::$app->controller->route == "/tiket/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['/tiket/index']) ?>"><i
                                class="menu-icon fa fa-list"></i><?= Yii::t('app', 'Tiket Center') ?>
                    </a>
                </li>

            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
<!-- /#left-panel -->
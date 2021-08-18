<!-- Left Panel -->
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="<?= Yii::$app->controller->route == "site/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['/site/index']) ?>"><i
                                class="menu-icon fa fa-laptop"></i><?= Yii::t('app', 'Dashboard') ?> </a>
                </li>
                <li class="<?= Yii::$app->controller->route == "telegram-bot/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['/telegram-bot/index']) ?>"><i
                                class="menu-icon fa fa-list"></i><?= Yii::t('app', 'Telegram Bots') ?>
                    </a>
                </li>

                <li class="<?= Yii::$app->controller->route == "translatemanager/source-message" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['/translatemanager/source-message']) ?>"><i
                                class="menu-icon fa fa-list"></i><?= Yii::t('app', 'Translations') ?>
                    </a>
                </li>
                <li class="<?= Yii::$app->controller->route == "eskizsms/default/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['/default/index']) ?>"><i
                                class="menu-icon fa fa-list"></i><?= Yii::t('app', 'Eskiz SMS') ?>
                    </a>
                </li>

                <li class="<?= Yii::$app->controller->route == "site-setting/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['/site-setting/index']) ?>"><i
                                class="menu-icon fa fa-list"></i><?= Yii::t('app', 'Site Settings') ?>
                    </a>
                </li>


                <li class="<?= Yii::$app->controller->route == "site-service/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['/site-service/index']) ?>"><i
                                class="menu-icon fa fa-list"></i><?= Yii::t('app', 'Site Services') ?>
                    </a>
                </li>


                <li class="<?= Yii::$app->controller->route == "site-app-clips/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['/site-app-clips/index']) ?>"><i
                                class="menu-icon fa fa-list"></i><?= Yii::t('app', 'Site App Clips') ?>
                    </a>
                </li>


                <li class="<?= Yii::$app->controller->route == "site-feature/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['/site-feature/index']) ?>"><i
                                class="menu-icon fa fa-list"></i><?= Yii::t('app', 'Site Feature') ?>
                    </a>
                </li>

                <li class="<?= Yii::$app->controller->route == "site-feature-image/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['/site-feature-image/index']) ?>"><i
                                class="menu-icon fa fa-list"></i><?= Yii::t('app', 'Site Feature Images') ?>
                    </a>
                </li>

                <li class="<?= Yii::$app->controller->route == "bot-price-table/index" ? "active" : "" ?>">
                    <a href="<?= \yii\helpers\Url::to(['/bot-price-table/index']) ?>"><i
                                class="menu-icon fa fa-list"></i><?= Yii::t('app', 'Bot Price Table') ?>
                    </a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
<!-- /#left-panel -->
<?php

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Dashboard');


$this->registerJsFile("https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.bundle.min.js", ['depends' => 'frontend\assets\AppAsset']);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.js", ['depends' => 'frontend\assets\AppAsset']);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/chartist-plugin-legend@0.6.2/chartist-plugin-legend.min.js", ['depends' => 'frontend\assets\AppAsset']);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/jquery.flot@0.8.3/jquery.flot.min.js", ['depends' => 'frontend\assets\AppAsset']);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/flot-pie@1.0.0/src/jquery.flot.pie.min.js", ['depends' => 'frontend\assets\AppAsset']);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/flot-spline@0.0.1/js/jquery.flot.spline.min.js", ['depends' => 'frontend\assets\AppAsset']);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/simpleweather@3.1.0/jquery.simpleWeather.min.js", ['depends' => 'frontend\assets\AppAsset']);
$this->registerJsFile("asset_files/js/init/weather-init.js", ['depends' => 'frontend\assets\AppAsset']);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/moment@2.22.2/moment.min.js", ['depends' => 'frontend\assets\AppAsset']);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js", ['depends' => 'frontend\assets\AppAsset']);
$this->registerJsFile("asset_files/js/init/fullcalendar-init.js", ['depends' => 'frontend\assets\AppAsset']);

$this->registerJsFile("frontend/web/js/dashboard.js", ['depends' => 'frontend\assets\AppAsset']);

$total_users_count = \frontend\models\api\BotUser::find()->joinWith('bot')->andWhere(['telegram_bot.user_id' => Yii::$app->user->identity->id])->count();
$total_bot_count = \frontend\models\api\TelegramBot::find()->andWhere(['user_id' => Yii::$app->user->identity->id])->count();
?>
<!-- Animated -->
<div class="animated fadeIn">
    <!-- Widgets  -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="stat-widget-five">
                        <div class="stat-icon dib flat-color-4">
                            <i class="pe-7s-users"></i>
                        </div>
                        <div class="stat-content">
                            <div class="text-left dib">
                                <div class="stat-text"><span class="count"><?= $total_users_count ?></span></div>
                                <div class="stat-heading"><?= t('All Users') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="stat-widget-five">
                        <div class="stat-icon dib flat-color-3">
                            <i class="pe-7s-browser"></i>
                        </div>
                        <div class="stat-content">
                            <div class="text-left dib">
                                <div class="stat-text"><span class="count"><?= $total_bot_count ?></span></div>
                                <div class="stat-heading"><?= t('All bots count') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="stat-widget-five">
                        <div class="stat-icon dib flat-color-1">
                            <i class="pe-7s-cash"></i>
                        </div>
                        <div class="stat-content">
                            <div class="text-left dib">
                                <div class="stat-text">$<span class="count">23569</span></div>
                                <div class="stat-heading">Revenue</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="stat-widget-five">
                        <div class="stat-icon dib flat-color-2">
                            <i class="pe-7s-cart"></i>
                        </div>
                        <div class="stat-content">
                            <div class="text-left dib">
                                <div class="stat-text"><span class="count">3435</span></div>
                                <div class="stat-heading">Sales</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- /Widgets -->

</div>
<!-- .animated -->
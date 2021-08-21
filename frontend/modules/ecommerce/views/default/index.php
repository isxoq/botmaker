<?php

/* @var $this yii\web\View */

use frontend\models\BotUserVisit;

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


//dd(Yii::$app->controller->module);

$total_revenue = \frontend\modules\ecommerce\models\Order::find()->andWhere(['order.status' => \frontend\modules\ecommerce\models\Order::STATUS_SUCCESS])->sum('total_price');
$sales = \frontend\modules\ecommerce\models\Order::find()->andWhere(['=', 'order.status', \frontend\modules\ecommerce\models\Order::STATUS_SUCCESS])->count();
$bot_users_count = \frontend\modules\ecommerce\models\BotUser::find()->count();
$today_visit = BotUserVisit::find()->andWhere([
    'bot_id' => Yii::$app->controller->module->bot->id,
])->andWhere(['between', 'datetime', strtotime(date('Y-m-d 00:00:00')), strtotime(date('Y-m-d 23:59:59'))])->count();


?>


<!-- Animated -->
<div class="animated fadeIn">
    <!-- Widgets  -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="stat-widget-five">
                        <div class="stat-icon dib flat-color-1">
                            <i class="pe-7s-cash"></i>
                        </div>
                        <div class="stat-content">
                            <div class="text-left dib">
                                <div class="stat-text"><span
                                            class="count"><?= $total_revenue ?></span>
                                </div>
                                <div class="stat-heading"><?= t('Total Revenue') ?></div>
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
                                <div class="stat-text"><span class="count"><?= $sales ?></span></div>
                                <div class="stat-heading"><?= t('Total Sales') ?></div>
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
                                <div class="stat-text"><span class="count"><?= $today_visit ?></span></div>
                                <div class="stat-heading"><?= t('Today visits') ?></div>
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
                        <div class="stat-icon dib flat-color-4">
                            <i class="pe-7s-users"></i>
                        </div>
                        <div class="stat-content">
                            <div class="text-left dib">
                                <div class="stat-text"><span class="count"><?= $bot_users_count ?></span></div>
                                <div class="stat-heading"><?= t('Total Clients') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Widgets -->
    <!--  Traffic  -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="box-title"><?= t('Traffic') ?> </h4>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card-body">
                            <div class="d-none"
                                 id="chart-url"><?= \yii\helpers\Url::to(['/ecommerce/default/traffic-cart-info'], true) ?></div>
                            <canvas data-url=""
                                    id="TrafficChart"></canvas>
                            <!--                            <div id="traffic-chart" class="traffic-chart"></div>-->
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card-body">
                            <div class="progress-box progress-1">
                                <h4 class="por-title"><?= t('Today visits') ?></h4>
                                <div class="por-txt"><?= $today_visit ?>
                                    (<?= round($bot_users_count ? $today_visit / $bot_users_count * 100 : 0) ?>%)
                                </div>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-flat-color-1" role="progressbar"
                                         style="width: <?= round($bot_users_count ? $today_visit / $bot_users_count * 100 : 0) ?>%;"
                                         aria-valuenow="<?= round($bot_users_count ? $today_visit / $bot_users_count * 100 : 0) ?>"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="progress-box progress-2">
                                <h4 class="por-title">Bounce Rate</h4>
                                <div class="por-txt">3,220 Users (24%)</div>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-flat-color-2" role="progressbar" style="width: 24%;"
                                         aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="progress-box progress-2">
                                <h4 class="por-title">Unique Visitors</h4>
                                <div class="por-txt">29,658 Users (60%)</div>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-flat-color-3" role="progressbar" style="width: 60%;"
                                         aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="progress-box progress-2">
                                <h4 class="por-title">Targeted Visitors</h4>
                                <div class="por-txt">99,658 Users (90%)</div>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-flat-color-4" role="progressbar" style="width: 90%;"
                                         aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div> <!-- /.card-body -->
                    </div>
                </div> <!-- /.row -->
                <div class="card-body"></div>
            </div>
        </div><!-- /# column -->
    </div>
    <!--  /Traffic -->
    <div class="clearfix"></div>
    <!-- Orders -->
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title"><?= t('Orders') ?> </h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table ">
                                <thead>
                                <tr>
                                    <th><?= t('ID') ?></th>
                                    <th><?= t('Full name') ?></th>
                                    <th><?= t('Total Price') ?></th>
                                    <th><?= t('Phone') ?></th>
                                    <th><?= t('Status') ?></th>
                                    <th><?= t('Payment Status') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach (\frontend\modules\ecommerce\models\Order::latestOrders() as $order): ?>
                                    <tr>
                                        <td> #<?= $order->id ?></td>
                                        <td><span class="name"><?= $order->user->full_name ?></span></td>
                                        <td><span class="product"><?= $order->total_price ?></span></td>
                                        <td><span class="phone"><?= $order->user->phone ?></span></td>
                                        <td>

                                            <?php if ($order->status == \frontend\modules\ecommerce\models\Order::STATUS_SUCCESS): ?>
                                                <span class="badge badge-complete"><?= $order->orderStatus ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-pending"><?= $order->orderStatus ?></span>
                                            <?php endif ?>
                                        </td>
                                        <td>

                                            <?php if ($order->status == \frontend\modules\ecommerce\models\Order::STATUS_PAYMENT_PAYED): ?>
                                                <span class="badge badge-complete"><?= $order->orderPaymentStatus ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-pending"><?= $order->orderPaymentStatus ?></span>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>

                                </tbody>
                            </table>
                        </div> <!-- /.table-stats -->
                    </div>
                </div> <!-- /.card -->
            </div>  <!-- /.col-lg-8 -->
        </div>
    </div>
    <!-- /.orders -->
</div>
<!-- .animated -->

<?php

$visits = BotUserVisit::visits();
$orders = \frontend\modules\ecommerce\models\Order::weeklyOrders();


$this->registerJs(
    "
if ($('#TrafficChart').length) {
        var ctx = document.getElementById('TrafficChart');
        ctx.height = 150;

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {$visits['labels']},
                datasets: [
                    {
                        label: '{$visits["label"]}',
                        borderColor: 'rgba(4, 73, 203, .09)',
                        borderWidth: '1',
                        backgroundColor: 'rgba(4, 73, 203, .5)',
                        data: {$visits['visits']}
                    },
                    {
                        label: '{$orders["label"]}',
                        borderColor: 'rgba(245, 23, 66, 0.9)',
                        borderWidth: '1',
                        backgroundColor: 'rgba(245, 23, 66, .5)',
                        pointHighlightStroke: 'rgba(245, 23, 66, .5)',
                        data: {$orders['orders']}
                        },
                   
                ]
            },
            options: {
                responsive: true,
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                }

            }
        });
    }
"
);
?>

<!--{-->
<!--label: "Targeted",-->
<!--borderColor: "rgba(40, 169, 46, 0.9)",-->
<!--borderWidth: "1",-->
<!--backgroundColor: "rgba(40, 169, 46, .5)",-->
<!--pointHighlightStroke: "rgba(40, 169, 46, .5)",-->
<!--data: [1000, 5200, 3600, 2600, 4200, 5300, 0]-->
<!--}-->
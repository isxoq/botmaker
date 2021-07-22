<?php

namespace frontend\modules\app\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "https://i.imgur.com/QRAUqs9.png",
        "https://i.imgur.com/QRAUqs9.png",
        "https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css",
        "https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css",
        "https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css",
        "https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css",
        "https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css",
        "https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css",
        "assets/css/cs-skin-elastic.css",
        "assets/css/style.css",
        "https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css",
        "https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css",
        "https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css",
        "https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css"
    ];
    public $js = [

        "https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js",
        "https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js",
        "https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js",
        "https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js",
        "assets/js/main.js",


    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}

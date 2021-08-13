<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class BlogAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        "/blog/vendor/css/bundle.min.css",
        "/blog/vendor/css/wow.css",
        "/blog/vendor/css/owl.carousel.min.css",
        "/blog/vapp-landing/css/line-awesome.min.css",
        "/blog/vapp-landing/css/style.css",

    ];
    public $js = [

        "/blog/vendor/js/bundle.min.js",
        "/blog/vendor/js/owl.carousel.min.js",
        "/blog/vendor/js/wow.min.js",
        "/blog/vendor/js/parallaxie.min.js",
        "/blog/vapp-landing/js/script.js",

    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}

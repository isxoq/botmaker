<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

\frontend\assets\BlogAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>


</head>
<body data-spy="scroll" data-target=".navbar" data-offset="90">
<?php $this->beginBody() ?>

<!--loader sec start-->
<div class="loader">
    <div class="box">
        <div class="loader-07"></div>
    </div>
</div>
<!--loader sec end-->

<!--header sec start-->
<header class="head-sec">
    <div class="container">
        <div class="top-navigation">
            <nav class="navbar navbar-expand-lg nav-up">
                <a class="navbar-brand" href="#"><img width="200" src="/images/logo2.svg" alt="logo"/></a>

                <div class="collapse navbar-collapse d-none d-lg-block" id="navbarNav">
                    <ul class="navbar-nav horizontal-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link scroll" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link scroll" href="#services-sec">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link scroll" href="#app-clips">Screen Shots</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link scroll" href="#app">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link scroll"
                               href="<?= \yii\helpers\Url::to(['site/index']) ?>"><?= t('Login') ?></a>
                        </li>
                    </ul>
                </div>

                <div class="navigation-toggle ml-auto d-block d-lg-none">
                    <ul class="slider-social toggle-btn" id="toggle-btn">
                        <li class="animated-wrap">
                            <a class="animated-element" href="javascript:void(0);">
                                <span></span>
                                <span></span>
                                <span></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

        </div>
        <div class="broad">
            <div class="close-nav">
                <i class="las la-times"></i>
            </div>
            <nav class="navbar navbar-light">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link scroll" href="#home"><i class="las la-angle-double-right"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link scroll" href="#services-sec"><i class="las la-angle-double-right"></i>
                            Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link scroll" href="#app-clips"><i class="las la-angle-double-right"></i> Screen
                            Shots</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link scroll" href="#app"><i class="las la-angle-double-right"></i> Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link scroll" href="#get-app-sec"><i class="las la-angle-double-right"></i>
                            Download</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<!--header sec end-->

<?= $content ?>


<!--footer sec start-->
<footer class="footer-sec" id="footer-sec">
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <div class="footer-icons d-flex">
                    <a href="javascript:void(0)" class="wow fadeInUp"><i class="lab la-facebook-f"></i> </a>
                    <a href="javascript:void(0)" class="wow fadeInDown"><i class="lab la-twitter"></i> </a>
                    <a href="javascript:void(0)" class="wow fadeInUp"><i class="lab la-google"></i> </a>
                    <a href="javascript:void(0)" class="wow fadeInDown"><i class="lab la-linkedin-in"></i> </a>
                    <a href="javascript:void(0)" class="wow fadeInUp"><i class="lab la-instagram"></i> </a>
                    <a href="javascript:void(0)" class="wow fadeInDown"><i class="las la-envelope"></i> </a>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--footer sec end-->


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

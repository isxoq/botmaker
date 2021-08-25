<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use backend\models\SiteSetting;

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
    <style>
        .sotib_olish_btn {
            padding: 10px 40px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            background-color: #ff4f5a;
            color: #fff;
            border-radius: 0;
            text-decoration: none;
            font-size: 14px;
            transition: .8s ease;
            border: solid 1px #ff4f5a;

        }

        .sotib_olish_btn:hover {
            background-color: #FFFFFF;
            color: #1f1f1f;
            border: solid 1px #FFFFFF;
        }


        .price {
            /*background: #fff;*/
            /*color: #fff;*/
            text-align: center;
            box-shadow: none;
            /*padding: 4rem;*/
            border-radius: 25px;
        }

        .price p {
            opacity: .8;
        }

        @media only screen and (max-width: 767px) {
            .imkoniyatlar h4 {
                font-size: 15px !important;
            }

            .imkoniyatlar ul {
                text-align: center;
            }

            .box {
                margin-top: 35px !important;
            }

            .box h2 {
                font-size: 20px;
            }

            .box p {
                margin: 0 0 10px;
            }
        }
    </style>


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
                <a class="navbar-brand" href="/"><img width="200" src="<?= SiteSetting::get('logo') ?>" alt="logo"/></a>

                <div class="collapse navbar-collapse d-none d-lg-block" id="navbarNav">
                    <ul class="navbar-nav horizontal-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link scroll" href="#home"><?= SiteSetting::get('Home') ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link scroll" href="#services-sec"><?= SiteSetting::get('Services') ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link scroll" href="#app-clips"><?= SiteSetting::get('Screen Shoots') ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link scroll" href="#app"><?= SiteSetting::get('Features') ?></a>
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
                        <a class="nav-link scroll" href="#home"><i
                                    class="las la-angle-double-right"></i> <?= SiteSetting::get('Home') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link scroll" href="#services-sec"><i class="las la-angle-double-right"></i>
                            <?= SiteSetting::get('Services') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link scroll" href="#app-clips"><i
                                    class="las la-angle-double-right"></i> <?= SiteSetting::get('Screen Shoots') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link scroll" href="#app"><i
                                    class="las la-angle-double-right"></i> <?= SiteSetting::get('Features') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link scroll" href="#<?= \yii\helpers\Url::to(['site/index']) ?>"><i
                                    class="las la-angle-double-right"></i>
                            <?= SiteSetting::get('Login') ?></a>
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
                    <?php if (t("Facebook Url") != "Facebook Url"): ?>
                        <a href="<?= t("Facebook Url") ?>" class="wow fadeInUp"><i class="lab la-facebook-f"></i> </a>
                    <?php endif ?>

                    <?php if (t("Twitter Url") != "Twitter Url"): ?>
                        <a href="<?= t("Twitter Url") ?>" class="wow fadeInDown"><i class="lab la-twitter"></i> </a>
                    <?php endif ?>
                    <?php if (t("Google Url") != "Google Url"): ?>
                        <a href="<?= t("Google Url") ?>" class="wow fadeInUp"><i class="lab la-google"></i> </a>
                    <?php endif ?>
                    <?php if (t("Linkedin Url") != "Linkedin Url"): ?>
                        <a href="<?= t("Linkedin Url") ?>" class="wow fadeInDown"><i class="lab la-linkedin-in"></i>
                        </a>
                    <?php endif ?>
                    <?php if (t("Instagram Url") != "Instagram Url"): ?>
                        <a href="<?= t("Instagram Url") ?>" class="wow fadeInUp"><i class="lab la-instagram"></i> </a>
                    <?php endif ?>
                    <?php if (t("Email Url") != "Email Url"): ?>
                        <a href="<?= t("Email Url") ?>" class="wow fadeInDown"><i class="las la-envelope"></i> </a>
                    <?php endif ?>
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

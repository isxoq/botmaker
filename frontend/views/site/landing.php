<?php
/*
Project Name: botmaker.loc
File Name: landing.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/13/2021 11:03 AM
*/

use backend\models\SiteSetting;

$this->title = t('Site Title');
?>


<!--Banner sec Start-->
<section class="banner-sec" id="banner-sec">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-12 col-lg-6 banner-details text-center text-lg-left">
                <div class="banner-inner-content">
                    <h4 class="banner-heading"><?= SiteSetting::get('Banner Heading') ?></h4>
                    <p class="banner-text"><?= SiteSetting::get('Banner Text') ?></p><a class="sotib_olish_btn"
                                                                                        href="<?= \yii\helpers\Url::to(['site/index']) ?>"> <?= SiteSetting::get('Banner Link') ?></a>
                </div>
            </div>
            <div class="col-12 col-lg-6 banner-img">
                <img src="<?= SiteSetting::get('Banner Image 1000x1000') ?>">
            </div>
        </div>
    </div>
</section>
<!--Banner sec end-->

<!--Services content start-->
<div id="services-sec" class="services-sec">
    <div class="container">
        <div class="row services-details text-center">
            <div class="col-12 col-md-10 col-lg-8 offset-md-1 offset-lg-2">
                <p class="sub-heading text-center"><?= SiteSetting::get('Services Sub Heading') ?></p>
                <h3 class="heading text-center"><?= SiteSetting::get('Services Heading') ?></h3>
                <p class="detail-text text-center"><?= SiteSetting::get('Services Detail') ?></p>
            </div>
        </div>
        <div class="row our-services">

            <?php foreach (\backend\models\SiteService::find()->all() as $service): ?>
                <div class="col-12 col-md-6 s-cards">
                    <div class="service-card text-center wow fadeInLeft" data-wow-duration="1s">
                        <a href="#">
                            <div class="image-holder">
                                <i class="<?= $service->icon ?>"></i>
                            </div>
                            <h3 class="service-card-heading"><?= $service->title ?></h3>
                            <p class="service-card-detail">
                                <?= $service->description ?>
                            </p>
                        </a>
                    </div>

                </div>
            <?php endforeach ?>

        </div>
    </div>
</div>
<!--Services content end-->

<!--Screen content end-->
<section class="app-clips" id="app-clips" style="background: url('/blog/vapp-landing/img/img2.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-10 col-lg-8 offset-md-1 offset-lg-2 app-clips-details">
                <p class="sub-heading text-center"><?= SiteSetting::get('App Clips Sub Heading') ?></p>
                <h3 class="heading text-center"><?= SiteSetting::get('App Clips Heading') ?></h3>
                <p class="detail-text text-center"><?= SiteSetting::get('App Clips Detail') ?></p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4 imkoniyatlar ">
                <ul>
                    <h4 class="mb-3"><i class="fa fa-check"></i> <?= t('Control Panel') ?></h4>
                    <h4 class="mb-3"><i class="fa fa-check"></i> <?= t('Products Orders') ?></h4>
                    <h4 class="mb-3"><i class="fa fa-check"></i> <?= t('Analysts') ?></h4>
                    <h4 class="mb-3"><i class="fa fa-check"></i> <?= t('Smart Push') ?></h4>
                    <h4 class="mb-3"><i class="fa fa-check"></i> <?= t('Payment Systems') ?></h4>
                </ul>
            </div>
            <div class="col-md-4">
                <div class="box price align-items-center">
                    <h2>
                        <?= \backend\models\BotPriceTable::find()->where(['month' => 1])->one()->price ?> <?= t('UZS') ?>
                    </h2>
                    <p><?= t('Start first month') ?></p>
                    <a href="<?= \yii\helpers\Url::to(['site/index']) ?>"
                       class="sotib_olish_btn">
                        <?= t('Podklyuchitsya') ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Screen content end-->


<!--App Section-->
<section id="app" class="app-sec">
    <div class="container">
        <!--Heading-->
        <div class="row">
            <div class="col-md-12 text-center wow fadeIn app-details">
                <div class="col-12 col-md-10 col-lg-8 offset-md-1 offset-lg-2">
                    <p class="sub-heading text-center"><?= SiteSetting::get('App Sec Sub Heading') ?></p>
                    <h3 class="heading text-center"><?= SiteSetting::get('App Sec Heading') ?></h3>
                    <p class="detail-text text-center"><?= SiteSetting::get('App Sec Detail') ?></p>
                </div>
            </div>
        </div>

        <!--App deatil-->
        <div class="row align-items-center text-center app-features-list">

            <div class="col-lg-4 mb-5 mb-lg-0 wow fadeInLeft">
                <?php foreach (\backend\models\SiteFeature::find()->limit(2)->all() as $feature): ?>
                    <div class="app-feature">
                        <i class="<?= $feature->icon ?>" aria-hidden="true"></i>
                        <h4 class="mb-3"><?= $feature->title ?></h4>
                        <p><?= $feature->description ?></p>
                    </div>
                <?php endforeach ?>
            </div>
            <!--app slider-->
            <div class="col-lg-4 mb-5 mb-lg-0 wow fadeInUp">
                <!--app Image-->
                <div class="app-image">
                    <img src="/blog/vapp-landing/img/iphone-img.png" alt="image">
                    <div id="app-slider" class="owl-carousel owl-theme">
                        <?php foreach (\backend\models\SiteFeatureImage::find()->all() as $image): ?>
                            <div class="item">
                                <img src="<?= $image->image ?>" alt="">
                            </div>
                        <?php endforeach ?>

                    </div>
                </div>
            </div>

            <div class="col-lg-4 wow fadeInRight">

                <?php foreach (\backend\models\SiteFeature::find()->offset(2)->all() as $feature): ?>
                    <div class="app-feature">
                        <i class="<?= $feature->icon ?>" aria-hidden="true"></i>
                        <h4 class="mb-3"><?= $feature->title ?></h4>
                        <p><?= $feature->description ?></p>
                    </div>
                <?php endforeach ?>

            </div>

        </div>

    </div>
</section>
<!--App Section End-->


<!--Get App Banner Start-->
<section id="get-app-sec" class="get-app-sec"
         style="background: url('<?= \yii\helpers\Url::to('/blog/vapp-landing/img/banner2.jpg', true) ?>');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-10 col-lg-8 offset-md-1 offset-lg-2 get-app-details text-center">
                <p class="sub-heading text-center"><?= SiteSetting::get('Get App Sub Heading') ?></p>
                <h3 class="heading text-center"><?= SiteSetting::get('Get App Heading') ?></h3>
                <a class="sotib_olish_btn"
                   href="<?= \yii\helpers\Url::to(['site/index']) ?>"> <?= SiteSetting::get('Banner Link') ?></a>
            </div>
        </div>
    </div>
</section>
<!---Get App Banner Start End-->


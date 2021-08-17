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

?>


<!--Banner sec Start-->
<section class="banner-sec" id="banner-sec">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-12 col-lg-6 banner-details text-center text-lg-left">
                <div class="banner-inner-content">
                    <h4 class="banner-heading"><?= SiteSetting::get('Banner Heading') ?></h4>
                    <p class="banner-text"><?= SiteSetting::get('Banner Text') ?></p> <?= SiteSetting::get('Banner Link') ?>
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

            <div class="col-12 col-md-6 s-cards">
                <div class="service-card text-center wow fadeInLeft" data-wow-duration="1s">
                    <a href="portfolio/standard-blog.html">
                        <div class="image-holder">
                            <i class="las la-motorcycle"></i>
                        </div>
                        <h3 class="service-card-heading">Branding Design</h3>
                        <p class="service-card-detail">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit augue diam, accumsan.
                        </p>
                    </a>
                </div>

            </div>
            <div class="col-12 col-md-6 s-cards">
                <div class="service-card text-center wow fadeInRight" data-wow-duration="1s">
                    <a href="portfolio/standard-blog.html">
                        <div class="image-holder">
                            <i class="las la-lightbulb"></i>
                        </div>
                        <h3 class="service-card-heading">Easy To Use</h3>
                        <p class="service-card-detail">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit augue diam, accumsan.
                        </p>
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-6 s-cards">
                <div class="service-card text-center wow fadeInLeft" data-wow-duration="1s">
                    <a href="portfolio/standard-blog.html">
                        <div class="image-holder">
                            <i class="las la-pencil-ruler"></i>
                        </div>
                        <h3 class="service-card-heading">Web Development</h3>
                        <p class="service-card-detail">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit augue diam, accumsan.
                        </p>
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-6 s-cards">
                <div class="service-card text-center wow fadeInRight" data-wow-duration="1s">
                    <a href="portfolio/standard-blog.html">
                        <div class="image-holder">
                            <i class="las la-fighter-jet"></i>
                        </div>
                        <h3 class="service-card-heading">Fast Builder</h3>
                        <p class="service-card-detail">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit augue diam, accumsan.
                        </p>
                    </a>
                </div>
            </div>
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
        <div class="app-clips-slider owl-carousel owl-theme">
            <?php foreach (\backend\models\SiteAppClips::find()->all() as $app): ?>
                <div class="item">
                    <img src="<?= $app->image ?>">
                </div>
            <?php endforeach ?>
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
                <!--App deatil item-->
                <div class="app-feature">
                    <i class="las la-hippo" aria-hidden="true"></i>
                    <h4 class="mb-3">Theme Options</h4>
                    <p>This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit Suspendisse in orci enim
                        gravida nibh.</p>
                </div>
                <!--App deatil item-->
                <div class="app-feature">
                    <i class="las la-cog" aria-hidden="true"></i>
                    <h4 class="mb-3">Customization</h4>
                    <p>This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit Suspendisse in orci enim
                        gravida nibh.</p>
                </div>
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
                        <div class="item">
                            <img src="/blog/vapp-landing/img/img2.png" alt="">
                        </div>
                        <div class="item">
                            <img src="/blog/vapp-landing/img/img3.png" alt="">
                        </div>
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
                <!--App deatil item-->
                <div class="app-feature">
                    <i class="las la-laptop-code" aria-hidden="true"></i>
                    <h4 class="mb-3">Powerful Code</h4>
                    <p>This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit Suspendisse in orci enim
                        gravida nibh.</p>
                </div>
                <!--App deatil item-->
                <div class="app-feature">
                    <i class="las la-folder-open" aria-hidden="true"></i>
                    <h4 class="mb-3">Documentation</h4>
                    <p>This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit Suspendisse in orci enim
                        gravida nibh.</p>
                </div>
            </div>

        </div>

    </div>
</section>
<!--App Section End-->


<!--Get App Banner Start-->
<section id="get-app-sec" class="get-app-sec" style="background: url('/blog//blog/vapp-landing/img/banner2.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-10 col-lg-8 offset-md-1 offset-lg-2 get-app-details text-center">
                <p class="sub-heading text-center"><?= SiteSetting::get('Get App Sub Heading') ?></p>
                <h3 class="heading text-center"><?= SiteSetting::get('Get App Heading') ?></h3>
                <p class="detail-text text-center"><?= SiteSetting::get('Get App Detail') ?></p>
            </div>
        </div>
    </div>
</section>
<!---Get App Banner Start End-->


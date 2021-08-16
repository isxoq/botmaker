<?php
/*
Project Name: botmaker.loc
File Name: index.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/13/2021 4:27 PM
*/

?>
    <div class="content">
        <div class="animated fadeIn">


            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><?= t('Bot Settings') ?></strong>
                        </div>
                        <div class="card-body">
                            <!-- Credit Card -->
                            <div id="pay-invoice">
                                <div class="card-body">
                                    <div class="form-group has-success">
                                        <label for="cc-name" class="control-label mb-1"><?= t('Bot Token') ?></label>
                                        <input id="bot-token" value="<?= Yii::$app->controller->module->bot->token ?>"
                                               name="bot-token" type="text"
                                               class="form-control cc-name valid" data-val="true"
                                               data-val-required="Please enter the name on card" autocomplete="cc-name"
                                               aria-required="true" aria-invalid="false" aria-describedby="cc-name">
                                        <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                              data-valmsg-replace="true"></span>
                                    </div>

                                    <div class="form-group has-success">
                                        <label for="cc-name" class="control-label mb-1"><?= t('Bot Name') ?></label>
                                        <input id="bot-name" name="bot-name"
                                               value="<?= Yii::$app->controller->module->bot->name ?>" type="text"
                                               class="form-control cc-name valid" data-val="true"
                                               data-val-required="Please enter the name on card" autocomplete="cc-name"
                                               aria-required="true" aria-invalid="false" aria-describedby="cc-name">
                                        <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                              data-valmsg-replace="true"></span>
                                    </div>
                                    <div class="btn btn-primary"
                                         id="update-bot-settings"><?= t('Update Settings') ?></div>
                                </div>
                            </div>

                        </div>
                    </div> <!-- .card -->

                </div><!--/.col-->

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><?= t("Delivery settings") ?></strong>
                        </div>
                        <div class="card-body">
                            <!-- Credit Card -->
                            <div id="pay-invoice">
                                <div class="card-body">
                                    <div class="form-group has-success">
                                        <label for="cc-name"
                                               class="control-label mb-1"><?= t('Delivery Price') ?></label>
                                        <input id="delivery_price"
                                               value="<?= Yii::$app->controller->module->bot->delivery_price ?>"
                                               name="delivery_price" type="number"
                                               class="form-control cc-name valid" data-val="true"
                                               data-val-required="Please enter the name on card" autocomplete="cc-name"
                                               aria-required="true" aria-invalid="false" aria-describedby="cc-name">
                                        <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                              data-valmsg-replace="true"></span>
                                    </div>

                                    <div class="form-group has-success">
                                        <label for="cc-name"
                                               class="control-label mb-1"><?= t('Min Order Price For Free Delivery') ?></label>
                                        <input id="min_delivery_price" name="min_delivery_price"
                                               value="<?= Yii::$app->controller->module->bot->min_order_price ?>"
                                               type="number"
                                               class="form-control cc-name valid" data-val="true"
                                               data-val-required="Please enter the name on card" autocomplete="cc-name"
                                               aria-required="true" aria-invalid="false" aria-describedby="cc-name">
                                        <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                              data-valmsg-replace="true"></span>
                                    </div>
                                    <div class="btn btn-primary"
                                         id="update-delivery-settings"><?= t('Update Settings') ?></div>
                                </div>
                            </div>

                        </div>
                    </div> <!-- .card -->
                </div>


            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><?= t("About Bot") ?></strong>
                        </div>
                        <div class="card-body">
                            <!-- Credit Card -->
                            <div id="pay-invoice">
                                <img id="pimage" src="<?= Yii::$app->controller->module->bot->about_image ?>" alt="">
                                <div class="card-body">
                                    <form action="#" id="fileUploadForm">
                                        <div class="form-group has-success">
                                            <label for="cc-name"
                                                   class="control-label mb-1"><?= t('Min Order Price For Free Delivery') ?></label>
                                            <input id="about_image" name="about_image"
                                                   value="<?= Yii::$app->controller->module->bot->about_image ?>"
                                                   type="file"
                                                   class="form-control cc-name valid"
                                                   aria-required="true" aria-invalid="false" aria-describedby="cc-name">
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
                                        </div>
                                        <div class="form-group has-success">
                                            <label for="description"
                                                   class="control-label mb-1"><?= t('Bot haqida') ?></label>
                                            <textarea class="form-control" name="about_description" id="description"
                                                      cols="30"
                                                      rows="10"><?= Yii::$app->controller->module->bot->about_text ?></textarea>

                                        </div>

                                    </form>
                                    <div class="btn btn-primary"
                                         id="update-about-settings"><?= t('Update Settings') ?></div>
                                </div>
                            </div>

                        </div>
                    </div> <!-- .card -->
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><?= t("Delete Bot") ?></strong>
                        </div>
                        <div class="card-body">
                            <!-- Credit Card -->
                            <div id="pay-invoice">
                                <p class="text-danger"><?= t('Danger ZONE!') ?></p>
                            </div>

                            <button class="btn btn-danger" id="delete_bot"><?= t('DELETE BOT') ?></button>

                        </div>
                    </div> <!-- .card -->
                </div>
            </div>


        </div><!-- .animated -->
    </div>

<?php
$apiUrlBot = \yii\helpers\Url::to(['bot-setting/update-setting', 'bot_id' => Yii::$app->controller->module->bot->id]);
$apiUrlDelivery = \yii\helpers\Url::to(['bot-setting/update-setting-delivery', 'bot_id' => Yii::$app->controller->module->bot->id]);
$apiUrlAbout = \yii\helpers\Url::to(['bot-setting/update-setting-about', 'bot_id' => Yii::$app->controller->module->bot->id]);
$apiUrlDelete = \yii\helpers\Url::to(['bot-setting/delete', 'bot_id' => Yii::$app->controller->module->bot->id]);
$apiBots = \yii\helpers\Url::to(['/telegram-bot/index'], true);


$js = <<<JS
        $(document).on('click','#update-bot-settings',function() {
            Swal.showLoading()
            $.ajax({
                url:'{$apiUrlBot}',
                type:'POST',
                data:{
                    'botToken':$('#bot-token').val(),
                    'botName':$('#bot-name').val()
                },
                success:function(data) {
                   Swal.hideLoading()
                    Swal.fire(
                      'OK!',
                      "Muvaffaqiyatli o'zgartirildi",
                      'success'
                    )
                },
                error:function(data) {
                  Swal.fire(
                      'Error!',
                      "Xatolik!",
                      'error'
                    )
                }
            })
        })
        
         $(document).on('click','#update-delivery-settings',function() {
            Swal.showLoading()
            $.ajax({
                url:'{$apiUrlDelivery}',
                type:'POST',
                data:{
                    'delivery_price':$('#delivery_price').val(),
                    'min_delivery_price':$('#min_delivery_price').val(),
                },
                success:function(data) {
                   Swal.hideLoading()
                    Swal.fire(
                      'OK!',
                      "Muvaffaqiyatli o'zgartirildi",
                      'success'
                    )
                },
                error:function(data) {
                  Swal.fire(
                      'Error!',
                      "Xatolik!",
                      'error'
                    )
                }
            })
        })
        
         $(document).on('click','#update-about-settings',function() {
            Swal.showLoading()
            
            
             var form = $('#fileUploadForm')[0];
            var data = new FormData(form);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "{$apiUrlAbout}",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
                console.log(data)
                $('#pimage').attr('src',data.about_image)
                  Swal.hideLoading()
                    Swal.fire(
                      'OK!',
                      "Muvaffaqiyatli o'zgartirildi",
                      'success'
                    )
            },
            error: function (e) {
                 Swal.fire(
                      'Error!',
                      "Xatolik!",
                      'error'
                    )

            }
        });
        
        })


        $(document).on('click','#delete_bot',function() {
            Swal.fire({
                  title: "Tasdiqlash uchun yes so'zini kiriting",
                  input: 'text',
                  inputAttributes: {
                    autocapitalize: 'off'
                  },
                  showCancelButton: true,
                  confirmButtonText: 'Delete',
                  showLoaderOnConfirm: true,
                  preConfirm: (text) => {
                      if (text!="yes"){
                          Swal.showValidationMessage(
                          `Tasdiqlanmadi`
                        )
                        return ;
                      }
                    return $.ajax({
                    url:'{$apiUrlDelete}',
                    type:'POST',
                    success:function(data) {
                      return data
                    },
                    error:function(data) {
                       Swal.showValidationMessage(
                          `Request failed`
                        )
                    }
                    })
                    
                  
                  },
                  allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    console.log(result)
                  if (result.value.deleted) {
                    
                    window.location= '{$apiBots}'
                  }
                })
        
        })


JS;


$this->registerJs($js);
?>
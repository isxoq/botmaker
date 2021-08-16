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
                        <div class="card-header"><strong>Company</strong><small> Form</small></div>
                        <div class="card-body card-block">
                            <div class="form-group"><label for="company"
                                                           class=" form-control-label">Company</label><input
                                        type="text" id="company" placeholder="Enter your company name"
                                        class="form-control">
                            </div>
                            <div class="form-group"><label for="vat" class=" form-control-label">VAT</label><input
                                        type="text" id="vat" placeholder="DE1234567890" class="form-control"></div>
                            <div class="form-group"><label for="street" class=" form-control-label">Street</label><input
                                        type="text" id="street" placeholder="Enter street name" class="form-control">
                            </div>
                            <div class="row form-group">
                                <div class="col-8">
                                    <div class="form-group"><label for="city"
                                                                   class=" form-control-label">City</label><input
                                                type="text" id="city" placeholder="Enter your city"
                                                class="form-control">
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group"><label for="postal-code" class=" form-control-label">Postal
                                            Code</label><input type="text" id="postal-code" placeholder="Postal Code"
                                                               class="form-control"></div>
                                </div>
                            </div>
                            <div class="form-group"><label for="country"
                                                           class=" form-control-label">Country</label><input
                                        type="text" id="country" placeholder="Country name" class="form-control"></div>
                        </div>
                    </div>
                </div>


            </div>


        </div><!-- .animated -->
    </div>

<?php
$apiUrl = \yii\helpers\Url::to(['bot-setting/update-setting', 'bot_id' => Yii::$app->controller->module->bot->id]);

$js = <<<JS
        $(document).on('click','#update-bot-settings',function() {
            $.ajax({
                url:'{$apiUrl}',
                type:'POST',
                data:{
                    'botToken':$('#bot-token').val(),
                    'botName':$('#bot-name').val()
                },
                success:function(data) {
                  console.log(data)
                }
            })
        })
JS;


$this->registerJs($js);
?>
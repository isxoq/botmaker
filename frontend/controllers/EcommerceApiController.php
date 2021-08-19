<?php

namespace frontend\controllers;
/*
Project Name: botmaker.loc
File Name: EcommerceApi.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 7/30/2021 3:47 PM
*/

use frontend\models\api\Cart;
use frontend\models\api\Category;
use frontend\models\api\Order;
use frontend\models\api\Product;
use frontend\models\api\ProductVariant;
use frontend\models\api\TelegramBot;
use frontend\models\api\BotUser;
use frontend\models\BotUserVisit;
use frontend\models\OrderProduct;
use Geocodio\Geocodio;
use yii;
use yii\base\BaseObject;

/**
 * Class EcommerceApiController
 * @package frontend\controllers
 *
 * @var $bot TelegramBot
 * @var $bot_user BotUser
 *
 */
class EcommerceApiController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    /**
     * Bot malumotini saqlash
     * @var
     */
    public $bot;

    /**
     * Ayni vaqtdagi foydalanuvchi
     * @var
     */
    public $bot_user;

    /**
     * Hook funksiyasi.  POST  request from Telegram server
     * @param $bot_id
     */
    public function actionHook($bot_id)
    {
        $raw = Yii::$app->request->rawBody;
        $update = yii\helpers\Json::decode($raw, false);
        $message = $update->message ?? null;
        $from = $update->message->from ?? null;
        $edited_message = $update->edited_message ?? null;
        $channel_post = $update->channel_post ?? null;
        $edited_channel_post = $update->edited_channel_post ?? null;
        $inline_query = $update->inline_query ?? null;
        $chosen_inline_result = $update->chosen_inline_result ?? null;
        $callback_query = $update->callback_query ?? null;


        $this->set_main_variables($from, $bot_id, $callback_query);


        if ($callback_query) {
            $this->callbackHandler($callback_query);
            return;
        }
        if ($message) {
            $this->messageHandler($message);
            return;
        }

        $this->mainMenu();


    }


    /**
     * Callback handler
     * @param $callback_query
     */
    protected function callbackHandler($callback_query)
    {

        $json = json_decode($callback_query->data);
        if ($json) {
            if ($json->action == "delete_from_cart") {
                if (!$this->getCart()) {
                    $this->telegram()->deleteMessage([
                        'chat_id' => $callback_query->from->id,
                        'message_id' => $callback_query->message->message_id
                    ]);
                    $this->mainMenu();
                    return;
                }
                $this->deleteFromCart($json);
                $this->updateCartInfo($callback_query);
            }
        }

        $this->telegram()->answerCallback([
            'callback_query_id' => $callback_query->id
        ]);
    }


    protected function sendError($message = "xato")
    {
        $this->telegram()->sendMessage([
            'text' => $message,
            'chat_id' => $this->bot_user->user_id,
        ]);
    }

    /**
     * Message tipidagi malumotlar bn ishlash
     * @param $message
     *
     */
    protected function messageHandler($message)
    {

        if ($message->text == t('About US')) {
            $this->sendAboutUs();
            return;
        }
        if ($message->text == t('My Orders')) {
            $this->sendUserOrders();
            return;
        }


        if ($this->bot_user->old_step == "set_language") {

            if ($message->text == t('Orqaga')) {
                $this->settingHandler();
                return;
            }
            if ($message->text == t('Uzbek')) {
                $this->bot_user->lang = "uz";
                $this->bot_user->save();
                Yii::$app->language = 'uz';
                $this->mainMenu();
            } elseif ($message->text == t('Russian')) {
                $this->bot_user->lang = "ru";
                $this->bot_user->save();
                Yii::$app->language = 'ru';
                $this->mainMenu();
            } else {
                $this->sendError();
            }
            return;
        }
        if ($this->bot_user->old_step == "settings") {

            if ($message->text == t('Orqaga')) {
                $this->mainMenu();
                return;
            }

            if ($message->text == t('Change language')) {
                $this->setStep('set_language', '');
                $this->telegram()->sendMessage([
                    'text' => t('Tilni tanlang'),
                    'chat_id' => $this->bot_user->user_id,
                    'parse_mode' => "html",
                    'reply_markup' => json_encode([
                        'keyboard' => [
                            [['text' => t('Uzbek')]],
                            [['text' => t('Russian')]],
                            [['text' => t('Orqaga')]],
                        ],
                        'resize_keyboard' => true
                    ])
                ]);
                return;
            }
        }

        if ($message->text == t('Settings')) {
            $this->settingHandler();
            return;
        }

        if ($message->text == t('Cancel order')) {
            $this->mainMenu();
            return;
        }

        if ($message->text == t('Clear all')) {
            $this->clearCart();
            $this->telegram()->sendMessage([
                'text' => t('Cart empty'),
                'chat_id' => $this->bot_user->user_id,
            ]);
            $this->sendMainCategories();
            return;
        }

        if ($this->bot_user->old_step == "setPhone") {

            if ($message->contact) {

                $phone = str_replace('+', "", $message->contact->phone_number);
                $this->bot_user->phone = $phone;
                $this->bot_user->save();

            } else {

                preg_match('/998\d{2}\d{7}/', $message->text, $match);

                if ($match && strlen($message->text) == 12) {
                    $this->bot_user->phone = $message->text;
                    $this->bot_user->save();
                } else {
                    $this->telegram()->sendMessage([
                        'text' => t('please send correct number', [
                            ]) . PHP_EOL . "<b>998xxyyyyyyy</b>",
                        'chat_id' => $this->bot_user->user_id,
                        'parse_mode' => "html"
                    ]);
                    return;
                }
            }

            $this->setStep('get_delivery_type', '');
            $this->getDeliveryType();
            return;

        }

        if ($this->bot_user->old_step == "get_delivery_type") {
            $id = Order::getDeliveryTypeId($message->text);
            if (!$id) {
                $this->sendError();
                return;
            }
            $order = Order::findOne([
                'bot_id' => $this->bot->id,
                'user_id' => $this->bot_user->id,
                'status' => Order::STATUS_ORDERING
            ]);
            $order->delivery_type = $id;
            $order->save();
            $this->setStep('get_payment_type', '');
            $this->getPaymentType();
            return;
        }

        if ($this->bot_user->old_step == "confirm_order") {
            if ($message->text == t("Bosh menyu")) {
                $this->mainMenu();
            } elseif ($message->text == t("Verify Order")) {

                $order = Order::findOne([
                    'bot_id' => $this->bot->id,
                    'user_id' => $this->bot_user->id,
                    'status' => Order::STATUS_ORDERING
                ]);

                $order->status = Order::STATUS_PROCESSING;
                $order->created_at = time();
                $order->payment_status = Order::STATUS_PAYMENT_NO_PAY;
                $order->total_price = $this->getCartTotal();
                $order->save();

                foreach ($this->getCart() as $cart) {

                    if ($cart->product) {
                        $price = $cart->product->price;
                    } elseif ($cart->productVariant) {
                        $price = $cart->productVariant->price;
                    }

                    $orderProduct = new OrderProduct;
                    $orderProduct->order_id = $order->id;
                    $orderProduct->product_id = $cart->product_id;
                    $orderProduct->product_variant_id = $cart->product_variant_id;
                    $orderProduct->price = $price;
                    $orderProduct->quantity = $cart->quantity;
                    $orderProduct->save();
                }

                if ($order->payment_type == Order::PAYMENT_TYPE_TERMINAL) {
                    $this->telegram()->sendMessage([
                        'text' => t('Order saved'),
                        'parse_mode' => "html",
                        'chat_id' => $this->bot_user->user_id,
                        'reply_markup' => json_encode([
                            'inline_keyboard' => [
                                [['text' => t('Pay with Click'), 'url' => $this->generateClickPayUrl($order->id, $order->total_price)]]
//                                [['text' => t('Pay with Payme'), 'url' => $this->generateClickPayUrl($order->id, $order->total_price)]]
                            ]
                        ])
                    ]);
                } else {
                    $this->telegram()->sendMessage([
                        'text' => t('Order saved'),
                        'parse_mode' => "html",
                        'chat_id' => $this->bot_user->user_id,
                    ]);
                }


                $this->clearCart();
                $this->mainMenu();
            }
            return;
        }

        if ($this->bot_user->old_step == "get_payment_type") {
            $id = Order::getPaymentTypeId($message->text);
            if (!$id) {
                $this->sendError();
                return;
            }
            $order = Order::findOne([
                'bot_id' => $this->bot->id,
                'user_id' => $this->bot_user->id,
                'status' => Order::STATUS_ORDERING
            ]);
            $order->payment_type = $id;
            $order->save();
            $this->setStep('get_address', '');

            if ($order->delivery_type == Order::DELIVERY_TYPE_OWN) {
                $this->setStep('confirm_order', '');
                $this->confirmOrder();
            } else {
                $this->getAddress();
            }

            return;
        }

        if ($this->bot_user->old_step == "get_address") {

            $address = $message->text;

            if ($message->location) {
                $latlong = $message->location->latitude . "," . $message->location->longitude;
                $address = $this->getLocationAddress($latlong);
            }

            $order = Order::findOne([
                'bot_id' => $this->bot->id,
                'user_id' => $this->bot_user->id,
                'status' => Order::STATUS_ORDERING
            ]);
            $order->delivery_address = $address;
            $order->save();
            $this->setStep('confirm_order', '');
            $this->confirmOrder();

            return;
        }

        if ($message->text == t('Rasmiylashtirish')) {
            $this->startOrder($message);
            return;
        }

        if ($message->text == t('/start')) {
            $this->telegram()->sendMessage([
                'text' => t('Welcome {name}!', [
                    'name' => $this->bot_user->full_name
                ]),
                'chat_id' => $this->bot_user->user_id,
            ]);
            $this->mainMenu();
            return;
        }

        if ($message->text == t('Buyurtma berish')) {
            $this->setStep('main_categories');

            $this->sendMainCategories();
            return;
        }

        if ($message->text == t('Orqaga')) {

            $this->bot_backward();
            return;
        }

        if ($message->text == t('Savat')) {
            $this->sendCartInfo();
            return;
        }

        if (str_contains($message->text, '❌')) {

//            $this->deleteFromCart(str_replace('❌ ', "", $message->text));
            $this->sendCartInfo();

            $this->telegram()->sendMessage([
                'text' => "Del click@",
                'chat_id' => $this->bot_user->user_id
            ]);
            return;
        }

        if ($message->text == t('Bosh menyu')) {
            $this->setStep("", "");
            $this->mainMenu();
            return;
        }

        if ($this->bot_user->old_step == "main_categories" || $this->bot_user->old_step == "in_category") {

            $this->categoryHandler($message);
            return;
        }

        if ($this->bot_user->old_step == "products") {

            $this->sendProductInfo($message);
            return;
        }

        if ($this->bot_user->old_step == "product_variants") {

            $this->sendProductVariantInfo($message);
            return;
        }

        if ($this->bot_user->old_step == "product" || $this->bot_user->old_step == "product_variant") {
            if ($message->text == t('Savatcha')) {

            } elseif ($message->text == t('Add to cart')) {
                if ($this->bot_user->old_step == "product") {
                    $this->addToCart(intval($this->bot_user->old_step_data), null, 1);
                } else if ($this->bot_user->old_step == "product_variant") {
                    $productVariant = ProductVariant::findOne(intval($this->bot_user->old_step_data));
                    $this->addToCart(intval($productVariant->product->id), intval($this->bot_user->old_step_data), 1);
                }
                $this->setStep('main_categories', '');
                $this->telegram()->sendMessage([
                    'chat_id' => $this->bot_user->user_id,
                    'text' => t('added to cart')
                ]);
                $this->sendMainCategories();
            } else {
                if (!is_numeric($message->text)) {
                    $this->telegram()->sendMessage([
                        'text' => t('Please send number!'),
                        'chat_id' => $this->bot_user->user_id,
                    ]);
                    return;
                }
                if ($this->bot_user->old_step == "product") {
                    $this->addToCart(intval($this->bot_user->old_step_data), null, intval($message->text));
                } else if ($this->bot_user->old_step == "product_variant") {
                    $productVariant = ProductVariant::findOne(intval($this->bot_user->old_step_data));
                    $this->addToCart(intval($productVariant->product->id), intval($this->bot_user->old_step_data), intval($message->text));
                }
                $this->setStep('main_categories', '');
                $this->telegram()->sendMessage([
                    'chat_id' => $this->bot_user->user_id,
                    'text' => t('added to cart')
                ]);
                $this->sendMainCategories();
            }
            return;
        }


        $this->mainMenu();
    }


    protected function sendAboutUs()
    {
        if ($this->bot->about_text) {
            if ($this->bot->about_image) {
                $this->telegram()->sendPhoto([
                    'caption' => $this->bot->about_text,
                    'chat_id' => $this->bot_user->user_id,
                    'photo' => yii\helpers\Url::to($this->bot->about_image, true)
                ]);
            } else {
                $this->telegram()->sendMessage([
                    'text' => $this->bot->about_text,
                    'chat_id' => $this->bot_user->user_id,
                ]);
            }
        } else {
            $this->telegram()->sendMessage([
                'text' => t('E commerce bot'),
                'chat_id' => $this->bot_user->user_id,
            ]);
        }
    }

    protected function settingHandler()
    {
        $this->setStep('settings', '');
        $this->telegram()->sendMessage([
            'text' => t('Sozlamalar'),
            'chat_id' => $this->bot_user->user_id,
            'parse_mode' => "html",
            'reply_markup' => json_encode([
                'keyboard' => [
                    [['text' => t('Change language')]],
                    [['text' => t('Orqaga')]],
                ],
                'resize_keyboard' => true
            ])
        ]);
    }

    protected function sendUserOrders()
    {

        $this->telegram()->sendMessage([
            'text' => t('your orders'),
            'chat_id' => $this->bot_user->user_id,
        ]);
        $orders = Order::find()
            ->andWhere([
                'bot_id' => $this->bot->id,
                'user_id' => $this->bot_user->id,
            ])
            ->andWhere(['!=', 'status', Order::STATUS_ORDERING])
            ->all();
        if (!$orders) {
            $this->telegram()->sendMessage([
                'text' => t('no orders'),
                'chat_id' => $this->bot_user->user_id,
            ]);
        } else {
            foreach ($orders as $order) {
                $text = t('order id') . $order->id . PHP_EOL;
                $text .= t('total_amount') . $order->total_price . PHP_EOL;
                $text .= t('datetime') . date('d.m.Y h:i:s', $order->created_at) . PHP_EOL;
                $text .= t('status') . $order->orderStatus . PHP_EOL;
                $text .= t('payment status') . $order->orderPaymentStatus . PHP_EOL;

                if ($order->payment_status == Order::STATUS_PAYMENT_NO_PAY && $order->payment_type == Order::PAYMENT_TYPE_TERMINAL) {
                    $this->telegram()->sendMessage([
                        'text' => $text,
                        'chat_id' => $this->bot_user->user_id,
                        'parse_mode' => "html",
                        'reply_markup' => json_encode([
                            'inline_keyboard' => [
                                [['text' => t('Pay with Click'), 'url' => $this->generateClickPayUrl($order->id, $order->total_price)]]
                            ]
                        ])
                    ]);
                } else {
                    $this->telegram()->sendMessage([
                        'text' => $text,
                        'chat_id' => $this->bot_user->user_id,
                    ]);

                }

            }
        }


    }

    protected function confirmOrder()
    {
        $order = Order::findOne([
            'bot_id' => $this->bot->id,
            'user_id' => $this->bot_user->id,
            'status' => Order::STATUS_ORDERING
        ]);
        $text = t('Phone') . $this->bot_user->phone . PHP_EOL;
        $text .= t('Order Payment type') . $order->paymentType . PHP_EOL;
        $text .= t('Order address') . $order->delivery_address . PHP_EOL;
        $text .= t('Order Delivery type') . $order->deliveryType . PHP_EOL . PHP_EOL;

        $total = 0;
        foreach ($this->getCart() as $item) {
            if ($item->productVariant) {
                $text .= "<b>" . $item->product->name . " (" . $item->productVariant->name . ")</b>" . PHP_EOL;
                $text .= $item->quantity . "*" . $item->productVariant->price . " = " . $item->quantity * $item->productVariant->price . PHP_EOL;
                $total += $item->productVariant->price;
            } else {
                $text .= "<b>" . $item->product->name . "</b>" . PHP_EOL;
                $text .= $item->quantity . "*" . $item->product->price . " = " . $item->quantity * $item->product->price . PHP_EOL;
                $total += $item->product->price;
            }
        }

        $text .= PHP_EOL . PHP_EOL;
        $text .= t('Jami') . $total;

        $this->telegram()->sendMessage([
            'text' => $text,
            'chat_id' => $this->bot_user->user_id,
            'parse_mode' => "html",
            'reply_markup' => json_encode([
                'keyboard' => [
                    [['text' => t('Verify Order')]],
                    [['text' => t('Order Comment')]],
                    [['text' => t("Cancel order")], ['text' => t('Bosh menyu')]]
                ],
                'resize_keyboard' => true
            ])
        ]);

    }

    protected function getLocationAddress($latlong)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $latlong . '&key=AIzaSyDSi71B2Dkf5GZ1ISXxIRa6hlYqH0QtYiU',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept-Language: uz'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $json = yii\helpers\Json::decode($response, false);
        return $json->results[1]->formatted_address;
    }

    protected function startOrder($message)
    {
        $cart = $this->getCart();
        if (!$cart) {
            $this->telegram()->sendMessage([
                'text' => t('Savat bom bosh'),
                'chat_id' => $this->bot_user->user_id,
            ]);
        } else {

            $order = Order::findOne([
                'bot_id' => $this->bot->id,
                'user_id' => $this->bot_user->id,
                'status' => Order::STATUS_ORDERING
            ]);

            if (!$order) {
                $order = new Order([
                    'bot_id' => $this->bot->id,
                    'user_id' => $this->bot_user->id,
                    'status' => Order::STATUS_ORDERING
                ]);
                $order->save();
            }

            if (!$this->bot_user->phone) {
                $this->setUserPhone();
                return;
            }

            if ($this->isDigitalOrder()) {
                $this->setStep('get_payment_type', '');
                $this->getPaymentType();
            }

            $this->setStep('get_delivery_type', '');
            $this->getDeliveryType();

        }

    }


    protected function getAddress()
    {
        $this->telegram()->sendMessage([
            'text' => t('send delivery address'),
            'chat_id' => $this->bot_user->user_id,
            'parse_mode' => "html",
            'reply_markup' => json_encode([
                'keyboard' => [
                    [['text' => t('send location'), 'request_location' => true]],
                    [['text' => t('Cancel order')]]
                ],
                'resize_keyboard' => true
            ])
        ]);
    }

    protected function getDeliveryType()
    {
        foreach (Order::deliveryTypes() as $deliveryTypeKey => $value) {
            $keys[0][] = ['text' => $value];
        }
        $keys[1] = [['text' => t("Cancel order")]];

        $this->telegram()->sendMessage([
            'text' => t('select delivery type'),
            'chat_id' => $this->bot_user->user_id,
            'parse_mode' => "html",
            'reply_markup' => json_encode([
                'keyboard' => $keys,
                'resize_keyboard' => true
            ])
        ]);
    }

    protected function getPaymentType()
    {
        foreach (Order::paymentTypes() as $deliveryTypeKey => $value) {
            $keys[0][] = ['text' => $value];
        }
        $keys[1] = [['text' => t("Cancel order")]];

        $this->telegram()->sendMessage([
            'text' => t('select payment type'),
            'chat_id' => $this->bot_user->user_id,
            'parse_mode' => "html",
            'reply_markup' => json_encode([
                'keyboard' => $keys,
                'resize_keyboard' => true
            ])
        ]);
    }

    protected function setUserPhone()
    {
        $this->setStep('setPhone', '');
        $this->telegram()->sendMessage([
            'text' => t('Please send your phone number!'),
            'chat_id' => $this->bot_user->user_id,
            'parse_mode' => "html",
            'reply_markup' => json_encode([
                'keyboard' => [
                    [['text' => t('Send my phone'), 'request_contact' => true]]
                ],
                'resize_keyboard' => true
            ])
        ]);
    }

    /**
     * Cart update
     * @param $callback_query
     */
    protected function updateCartInfo($callback_query)
    {

        if (!$this->getCart()) {
            $this->telegram()->deleteMessage([
                'chat_id' => $callback_query->from->id,
                'message_id' => $callback_query->message->message_id
            ]);
            $this->mainMenu();
            return;
        }

        $text = t('Savatcha') . PHP_EOL . PHP_EOL;

        $total = 0;
        foreach ($this->getCart() as $item) {
            if ($item->productVariant) {
                $text .= "<b>" . $item->product->name . " (" . $item->productVariant->name . ")</b>" . PHP_EOL;
                $text .= $item->quantity . "*" . $item->productVariant->price . " = " . $item->quantity * $item->productVariant->price . PHP_EOL;
                $total += $item->productVariant->price;
            } else {
                $text .= "<b>" . $item->product->name . "</b>" . PHP_EOL;
                $text .= $item->quantity . "*" . $item->product->price . " = " . $item->quantity * $item->product->price . PHP_EOL;
                $total += $item->product->price;
            }
        }

        $text .= PHP_EOL . PHP_EOL;
        $text .= t('Jami') . $total;


        $delKeys = [];
        foreach ($this->getCart() as $item) {
            if ($item->productVariant) {
                $delKeys[] = [['text' => "❌ " . $item->product->name . " (" . $item->productVariant->name . ")", 'callback_data' => json_encode([
                    'action' => 'delete_from_cart',
                    'type' => 'pv',
                    'p_id' => $item->product->id,
                    'id' => $item->productVariant->id
                ])]];
            } else {
                $delKeys[] = [['text' => "❌ " . $item->product->name, 'callback_data' => json_encode([
                    'action' => 'delete_from_cart',
                    'type' => 'p',
                    'id' => $item->product->id
                ])]];
            }
        }

        $this->telegram()->editMessageText([
            'chat_id' => $callback_query->message->chat->id,
            'message_id' => $callback_query->message->message_id,
            'text' => $text,
            'parse_mode' => "html"
        ]);
        $this->telegram()->editMessageReplyMarkup([
            'chat_id' => $callback_query->message->chat->id,
            'message_id' => $callback_query->message->message_id,
            'reply_markup' => json_encode([
                'inline_keyboard' => $delKeys,
            ])
        ]);

    }

    /**
     * Savat malumotlarini jonatish
     */
    protected function sendCartInfo()
    {


        $text = t('Savatcha') . PHP_EOL . PHP_EOL;

        $total = 0;
        foreach ($this->getCart() as $item) {
            if ($item->productVariant) {
                $text .= "<b>" . $item->product->name . " (" . $item->productVariant->name . ")</b>" . PHP_EOL;
                $text .= $item->quantity . "*" . $item->productVariant->price . " = " . $item->quantity * $item->productVariant->price . PHP_EOL;
                $total += $item->productVariant->price;
            } else {
                $text .= "<b>" . $item->product->name . "</b>" . PHP_EOL;
                $text .= $item->quantity . "*" . $item->product->price . " = " . $item->quantity * $item->product->price . PHP_EOL;
                $total += $item->product->price;
            }
        }

        $text .= PHP_EOL . PHP_EOL;
        $text .= t('Jami') . $total;


        $delKeys = [];
        foreach ($this->getCart() as $item) {
            if ($item->productVariant) {
                $delKeys[] = [['text' => "❌ " . $item->product->name . " (" . $item->productVariant->name . ")", 'callback_data' => json_encode([
                    'action' => 'delete_from_cart',
                    'type' => 'pv',
                    'p_id' => $item->product->id,
                    'id' => $item->productVariant->id
                ])]];
            } else {
                $delKeys[] = [['text' => "❌ " . $item->product->name, 'callback_data' => json_encode([
                    'action' => 'delete_from_cart',
                    'type' => 'p',
                    'id' => $item->product->id
                ])]];
            }
        }

        if (!$this->getCart()) {
            $this->telegram()->sendMessage([
                'text' => t('Savat bom bosh'),
                'chat_id' => $this->bot_user->user_id,
            ]);
            return;
        }
        $this->telegram()->sendMessage([
            'text' => $text,
            'chat_id' => $this->bot_user->user_id,
            'parse_mode' => "html",
            'reply_markup' => json_encode([
                'inline_keyboard' => $delKeys,
            ])
        ]);
        $this->telegram()->sendMessage([
            'text' => t('Select'),
            'chat_id' => $this->bot_user->user_id,
            'parse_mode' => "html",
            'reply_markup' => json_encode([
                'keyboard' => [
                    [['text' => t('Orqaga')], ['text' => t('Rasmiylashtirish')]],
                    [['text' => t("Clear all")], ['text' => t('Bosh menyu')]]
                ],
                'resize_keyboard' => true
            ])
        ]);

    }

    /**
     * Mahsulot variantlarini jo'natish
     * @param $message
     */
    protected function sendProductVariantInfo($message)
    {
        $product_variant = ProductVariant::findOne(['name' => $message->text]);
        if (!$product_variant) {
            $this->sendError(t('product variant not found'));
            return;
        }
        $this->setStep('product_variant', strval($product_variant->id));
        $this->sendProductVariantDetail($product_variant);
    }

    /**
     * Mahsulot haqida malumot yuborish
     * @param $message
     */
    protected function sendProductInfo($message)
    {
        $product = Product::find()
            ->joinWith('category')
            ->andWhere(['product.name' => $message->text, 'category.bot_id' => $this->bot->id])
            ->one();
        if (!$product) {
            $this->sendError(t('product not found'));
            return;
        }
        if ($product->productVariants) {

            $this->setStep('product_variants', strval($product->id));
            $text = "<b>" . $product->name . "</b>" . PHP_EOL . PHP_EOL;
            $text .= $product->description . PHP_EOL . PHP_EOL;
            $text .= t('Iltimos, variantlardan birini tanlang');

            if ($product->image) {
                $this->telegram()->sendPhoto([
                    'photo' => yii\helpers\Url::to([$product->image], true),
//                    'photo' => "https://i.ytimg.com/vi/WapKfi8L6yE/maxresdefault.jpg",
                    'caption' => $text,
                    'chat_id' => $this->bot_user->user_id,
                    'parse_mode' => "html",
                    'reply_markup' => json_encode([
                        'keyboard' => $this->generateButtons($product->productVariants),
                        'resize_keyboard' => true
                    ])
                ]);
            }

        } else {
            $this->setStep('product', strval($product->id));
            $this->sendProductDetail($product);
        }

    }

    protected function sendProductVariantDetail($product_variant)
    {
        $text = "<b>" . $product_variant->product->name . " (" . $product_variant->name . ")</b>" . PHP_EOL . PHP_EOL;

        if ($product_variant->old_price) {
            $text .= t("narx") . "<s>" . $product_variant->old_price . "</s> " . $product_variant->price . PHP_EOL . PHP_EOL;
        } else {
            $text .= t("narx") . $product_variant->price . PHP_EOL . PHP_EOL;
        }

        $messageText = t('Buyurtma uchun sonni tanlang yoki yuboring');

        if ($product_variant->product->product_type == \frontend\modules\ecommerce\models\Product::TYPE_DIGITAL) {
            $messageText = t('Buyurtma uchun savatga tugmasini bosing');
            $this->sendProductVariantCartButtons($text, $messageText, $product_variant);
        } else {
            $this->sendProductVariantCartButtons($text, $messageText, $product_variant);
        }

    }

    protected function sendProductDetail($product)
    {

        $text = "<b>" . $product->name . "</b>" . PHP_EOL . PHP_EOL;
        if ($product->old_price) {
            $text .= t("narx") . "<s>" . $product->old_price . "</s> " . $product->price . PHP_EOL . PHP_EOL;
        } else {
            $text .= t("narx") . $product->price . PHP_EOL . PHP_EOL;
        }

        $text .= $product->description . PHP_EOL . PHP_EOL;
        $messageText = t('Buyurtma uchun sonni tanlang yoki yuboring');

        if ($product->product_type == \frontend\modules\ecommerce\models\Product::TYPE_DIGITAL) {
            $messageText = t('Buyurtma uchun savatga tugmasini bosing');
            $this->sendProductCartButtons($text, $messageText, $product);
        } else {
            $this->sendProductCartButtons($text, $messageText, $product);
        }


    }

    protected function sendProductVariantCartButtons($text, $messageText, $product_variant)
    {
        echo "Ass";
        if ($product_variant->product->product_type == \frontend\modules\ecommerce\models\Product::TYPE_DIGITAL) {
            $this->telegram()->sendMessage([
                'text' => $text . $messageText,
                'chat_id' => $this->bot_user->user_id,
                'parse_mode' => "html",
                'reply_markup' => json_encode([
                    'keyboard' => [
                        [['text' => t('Add to cart')]],
                        [['text' => t('Savat')], ['text' => t('Orqaga')]],
                    ],
                    'resize_keyboard' => true
                ])
            ]);
            return;
        }

        $this->telegram()->sendMessage([
            'text' => $text . $messageText,
            'chat_id' => $this->bot_user->user_id,
            'parse_mode' => "html",
            'reply_markup' => json_encode([
                'keyboard' => [
                    [['text' => 1], ['text' => 2], ['text' => 3]],
                    [['text' => 4], ['text' => 5], ['text' => 6]],
                    [['text' => 7], ['text' => 8], ['text' => 9]],
                    [['text' => t('Savat')], ['text' => t('Orqaga')]],
                ],
                'resize_keyboard' => true
            ])
        ]);
    }

    protected function sendProductCartButtons($text, $messageText, $product)
    {
        if ($product->product_type == \frontend\modules\ecommerce\models\Product::TYPE_DIGITAL) {
            if ($product->image) {
                $this->telegram()->sendPhoto([
                    'photo' => yii\helpers\Url::to([$product->image], true),
//                'photo' => "https://i.ytimg.com/vi/WapKfi8L6yE/maxresdefault.jpg",
                    'caption' => $text . $messageText,
                    'chat_id' => $this->bot_user->user_id,
                    'parse_mode' => "html",
                    'reply_markup' => json_encode([
                        'keyboard' => [
                            [['text' => t('Add to cart')]],
                            [['text' => t('Savat')], ['text' => t('Orqaga')]],
                        ],
                        'resize_keyboard' => true
                    ])
                ]);
            } else {
                $this->telegram()->sendMessage([
                    'text' => $text . $messageText,
                    'chat_id' => $this->bot_user->user_id,
                    'parse_mode' => "html",
                    'reply_markup' => json_encode([
                        'keyboard' => [
                            [['text' => t('Add to cart')]],
                            [['text' => t('Savat')], ['text' => t('Orqaga')]],
                        ],
                        'resize_keyboard' => true
                    ])
                ]);
            }

            return;
        }

        if ($product->image) {
            $this->telegram()->sendPhoto([
                'photo' => yii\helpers\Url::to([$product->image], true),
//                'photo' => "https://i.ytimg.com/vi/WapKfi8L6yE/maxresdefault.jpg",
                'caption' => $text . $messageText,
                'chat_id' => $this->bot_user->user_id,
                'parse_mode' => "html",
                'reply_markup' => json_encode([
                    'keyboard' => [
                        [['text' => 1], ['text' => 2], ['text' => 3]],
                        [['text' => 4], ['text' => 5], ['text' => 6]],
                        [['text' => 7], ['text' => 8], ['text' => 9]],
                        [['text' => t('Savat')], ['text' => t('Orqaga')]],
                    ],
                    'resize_keyboard' => true
                ])
            ]);
        } else {
            $this->telegram()->sendMessage([
                'text' => $text . $messageText,
                'chat_id' => $this->bot_user->user_id,
                'parse_mode' => "html",
                'reply_markup' => json_encode([
                    'keyboard' => [
                        [['text' => 1], ['text' => 2], ['text' => 3]],
                        [['text' => 4], ['text' => 5], ['text' => 6]],
                        [['text' => 7], ['text' => 8], ['text' => 9]],
                        [['text' => t('Savat')], ['text' => t('Orqaga')]],
                    ],
                    'resize_keyboard' => true
                ])
            ]);
        }
    }

    protected function categoryHandler($message)
    {
        $subCategories = Category::getSubCategories($message->text, $this->bot->id);
        if ($subCategories) {

            $this->setStep('in_category', strval(Category::findOne(['name' => $message->text, 'bot_id' => $this->bot->id])->id));
            $this->telegram()->sendMessage([
                'text' => $message->text,
                'chat_id' => $this->bot_user->user_id,
                'parse_mode' => "html",
                'reply_markup' => json_encode([
                    'keyboard' => $this->generateButtons($subCategories),
                    'resize_keyboard' => true
                ])
            ]);
        } else {
            $category = Category::findOne(['name' => $message->text]);
            if ($category) {
                if ($category->products) {
                    $this->setStep('products', strval($category->id));
                    $this->sendProducts($category);
                } else {
                    $this->sendError(t('products not found'));
                }
            } else {
                $this->sendError(t('category not found'));
            }
        }
    }


    protected function sendProducts($category)
    {
        $this->telegram()->sendMessage([
            'text' => $category->name,
            'chat_id' => $this->bot_user->user_id,
            'parse_mode' => "html",
            'reply_markup' => json_encode([
                'keyboard' => $this->generateButtons($category->products),
                'resize_keyboard' => true
            ])
        ]);
    }

    /**
     * Botda orqaga qaytish
     *
     */
    protected function bot_backward()
    {
        if ($this->bot_user->old_step == "product_variant") {
            $product_variant = ProductVariant::findOne(intval($this->bot_user->old_step_data));
            $this->setStep('product_variants', strval($product_variant->product->id));
            print_r($product_variant->product->productVariants);
            $this->telegram()->sendMessage([
                'text' => $product_variant->product->name,
                'chat_id' => $this->bot_user->user_id,
                'parse_mode' => "html",
                'reply_markup' => json_encode([
                    'keyboard' => $this->generateButtons($product_variant->product->productVariants),
                    'resize_keyboard' => true
                ])
            ]);
            return;
        }

        if ($this->bot_user->old_step == "product" || $this->bot_user->old_step == "product_variants") {
            $product = Product::findOne(intval($this->bot_user->old_step_data));
            $this->setStep('products', strval($product->category->id));

            $this->telegram()->sendMessage([
                'text' => $product->category->name,
                'chat_id' => $this->bot_user->user_id,
                'parse_mode' => "html",
                'reply_markup' => json_encode([
                    'keyboard' => $this->generateButtons($product->category->products),
                    'resize_keyboard' => true
                ])
            ]);
            return;
        }
        if ($this->bot_user->old_step == "in_category" || $this->bot_user->old_step == "products") {
            $category = Category::findOne(intval($this->bot_user->old_step_data));
            if ($category->parent) {
                $this->setStep('in_category', strval($category->parent->id));

                $this->telegram()->sendMessage([
                    'text' => $category->parent->name,
                    'chat_id' => $this->bot_user->user_id,
                    'parse_mode' => "html",
                    'reply_markup' => json_encode([
                        'keyboard' => $this->generateButtons($category->parent->sCategories),
                        'resize_keyboard' => true
                    ])
                ]);
            } else {
                $this->setStep('main_categories', '');
                $this->sendMainCategories();
            }
            return;
        }
        if ($this->bot_user->old_step == "main_categories") {
            $this->setStep('');
            $this->mainMenu();
        }
    }


    protected function sendStep()
    {
        $this->telegram()->sendMessage([
            'text' => $this->bot_user->old_step,
            'chat_id' => $this->bot_user->user_id
        ]);
    }


    protected function generateButtons($buttons)
    {
        $keys = [];
        if ($buttons) {
            if (count($buttons) % 2 == 0) {
                for ($i = 0; $i < count($buttons); $i += 2) {
                    $keys[] = [['text' => $buttons[$i]->name], ['text' => $buttons[$i + 1]->name]];
                }
            } else {
                $keys[] = [['text' => $buttons[0]->name]];

                if (count($buttons) >= 3) {
                    for ($i = 1; $i < count($buttons); $i += 2) {
                        $keys[] = [['text' => $buttons[$i]->name], ['text' => $buttons[$i + 1]->name]];
                    }
                }
            }
        }

        $keys[] = [['text' => t('Savat')], ['text' => t('Rasmiylashtirish')]];
        $keys[] = [['text' => t('Orqaga')], ['text' => t('Bosh menyu')]];

        return $keys;
    }

    protected function sendMainCategories()
    {

        $mainCategories = Category::find()
            ->andWhere(['bot_id' => $this->bot->id])
            ->andWhere(['IS', 'parent_id', null])
            ->all();


        $keys = [];
        if ($mainCategories) {
            if (count($mainCategories) % 2 == 0) {
                for ($i = 0; $i < count($mainCategories); $i += 2) {
                    $keys[] = [['text' => $mainCategories[$i]->name], ['text' => $mainCategories[$i + 1]->name]];
                }
            } else {
                $keys[] = [['text' => $mainCategories[0]->name]];

                if (count($mainCategories) >= 3) {
                    for ($i = 1; $i < count($mainCategories); $i += 2) {
                        $keys[] = [['text' => $mainCategories[$i]->name], ['text' => $mainCategories[$i + 1]->name]];
                    }
                }
            }
        }

        $keys[] = [['text' => t('Savat')], ['text' => t('Rasmiylashtirish')]];
        $keys[] = [['text' => t('Orqaga')], ['text' => t('Bosh menyu')]];

        $this->telegram()->sendMessage([
            'text' => t('Kategoriyalar'),
            'chat_id' => $this->bot_user->user_id,
            'parse_mode' => "html",
            'reply_markup' => json_encode([
                'keyboard' => $keys,
                'resize_keyboard' => true
            ])
        ]);
    }

    /**
     * Asosiy o'zgaruvchilarni oladi
     * @param $from
     */
    protected function set_main_variables($from, $bot_id, $callback_query = null)
    {

        $this->bot = TelegramBot::findOne(['bot_id' => $bot_id]);


        $bot_user = BotUser::findOne(['user_id' => $from->id, 'bot_id' => $this->bot->id]);


        if (!$this->bot->isAvailable) {
            $this->telegram()->sendMessage([
                'text' => t('Bot temporary blocked'),
                'chat_id' => $bot_user->user_id,
            ]);
            exit();
        }
        if ($callback_query) {
            $bot_user = BotUser::findOne(['user_id' => $callback_query->from->id, 'bot_id' => $this->bot->id]);
        }

        if (!$bot_user) {
            $bot_user = new BotUser([
                'bot_id' => $this->bot->id,
                'last_action_date' => time(),
                'status' => 1,
                'user_id' => strval($from->id),
                'username' => $from->username,
                'full_name' => $from->first_name . " " . $from->last_name,
                'lang' => 'uz'
            ]);
            if (!$bot_user->save()) {
                var_dump($bot_user->errors);
            }
        }

        $this->bot_user = $bot_user;
        Yii::$app->language = $bot_user->lang;

        $visit = BotUserVisit::find()->andWhere([
            'bot_id' => $this->bot->id,
            'bot_user_id' => $bot_user->id
        ])->andWhere(['between', 'datetime', strtotime(date('Y-m-d 00:00:00')), strtotime(date('Y-m-d 23:59:59'))])->one();


        if (!$visit) {
            $visit = new BotUserVisit([
                'bot_id' => $this->bot->id,
                'bot_user_id' => $bot_user->id,
                'datetime' => time(),
            ]);
            $visit->save();
        }

        $visit->use_count += 1;
        $visit->save();

    }

    protected function sendMessage($data)
    {
        $data['chat_id'] = $this->bot_user->user_id;
        return $this->telegram()->sendMessage($data);
    }

    /**
     * Botga asosiy menyuni jo'natish
     */
    protected function mainMenu()
    {

        $this->setStep('');

        $this->telegram()->sendMessage([
            'text' => t('Welcome {name}', [
                'name' => $this->bot_user->full_name
            ]),
            'chat_id' => $this->bot_user->user_id,
            'parse_mode' => "html",
            'reply_markup' => json_encode([
                'keyboard' => [
                    [['text' => t('Buyurtma berish')]],
                    [['text' => t('My Orders')], ['text' => t('Settings')]],
                    [['text' => t('About US')], ['text' => t('Make Comment')]],
                ],
                'resize_keyboard' => true
            ])
        ]);
    }


    /**
     * Foydalanuvchining qadamini saqlab olish
     * @param $step
     * @param string $data
     */
    protected function setStep($step, $data = "")
    {
        $this->bot_user->old_step = $step;
        $this->bot_user->old_step_data = $data;
        if (!$this->bot_user->save()) {
            print_r($this->bot_user->errors);
        }
    }


    /**
     * Telegram moduli
     * @return \common\components\TelegramApi
     */
    protected function telegram(): \common\components\TelegramApi
    {
        return telegram_core([
            'token' => $this->bot->token,
        ]);
    }


    protected function addToCart($product_id, $variant_id, $quantity)
    {
        $cart = Cart::find()
            ->andWhere([
                'product_id' => $product_id,
                'product_variant_id' => $variant_id,
                'bot_id' => $this->bot->id,
                'bot_user_id' => $this->bot_user->id,
            ])->one();

        if ($cart) {
            $cart->quantity += $quantity;
            $cart->save();
        } else {
            $cart = new Cart([
                'product_id' => $product_id,
                'product_variant_id' => $variant_id,
                'bot_id' => $this->bot->id,
                'bot_user_id' => $this->bot_user->id,
                'quantity' => $quantity
            ]);
            $cart->save();
        }


    }

    protected function getCartTotal()
    {
        $total = 0;
        $carts = Cart::find()
            ->andWhere([
                'bot_id' => $this->bot->id,
                'bot_user_id' => $this->bot_user->id,
            ])->all();
        foreach ($carts as $cart) {
            $total += $cart->quantity * $cart->product->price;
        }
        return $total;
    }

    protected function getCart()
    {
        return Cart::find()
            ->andWhere([
                'bot_id' => $this->bot->id,
                'bot_user_id' => $this->bot_user->id,
            ])->all();
    }

    protected function clearCart()
    {
        Cart::deleteAll([
            'bot_id' => $this->bot->id,
            'bot_user_id' => $this->bot_user->id,
        ]);
    }

    protected function deleteFromCart($data)
    {

        if ($data->type == "p") {
            $cart = Cart::find()
                ->andWhere([
                    'product_id' => $data->id,
//                    'product_variant_id' => $variant_id,
                    'bot_id' => $this->bot->id,
                    'bot_user_id' => $this->bot_user->id,
                ])->one();
            $cart->delete();
        }

        if ($data->type == "pv") {
            $cart = Cart::find()
                ->andWhere([
                    'product_id' => $data->p_id,
                    'product_variant_id' => $data->id,
                    'bot_id' => $this->bot->id,
                    'bot_user_id' => $this->bot_user->id,
                ])->one();
            $cart->delete();
        }
    }

    protected function generateClickPayUrl($order_id, $amount)
    {

        $service_id = $this->bot->click_service_id;
        $merchant_id = $this->bot->click_merchant_id;

        return "https://my.click.uz/services/pay?service_id={$service_id}&merchant_id={$merchant_id}&amount={$amount}&transaction_param={$order_id}";
    }

    protected function isDigitalOrder()
    {
        foreach ($this->getCart() as $item) {
            if ($item->product) {
                if ($item->product_type == \frontend\modules\ecommerce\models\Product::TYPE_DIGITAL) {
                    return true;
                }
            } elseif ($item->productVariant) {
                if ($item->productVariant->product->product_type == \frontend\modules\ecommerce\models\Product::TYPE_DIGITAL) {
                    return true;
                }
            }
        }

        return false;
    }

}


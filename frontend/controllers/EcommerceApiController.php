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
use frontend\models\api\Product;
use frontend\models\api\ProductVariant;
use frontend\models\api\TelegramBot;
use frontend\models\api\BotUser;
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
        $message = $update->message;
        $from = $update->message->from;
        $edited_message = $update->edited_message;
        $channel_post = $update->channel_post;
        $edited_channel_post = $update->edited_channel_post;
        $inline_query = $update->inline_query;
        $chosen_inline_result = $update->chosen_inline_result;
        $callback_query = $update->callback_query;


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
                $this->deleteFromCart($json);
                $this->updateCartInfo($callback_query);
            }
        }

        print_r($this->telegram()->sendMessage([
            'text' => $callback_query->data,
            'chat_id' => $this->bot_user->user_id
        ]));

        $this->telegram()->answerCallback([
            'callback_query_id' => $callback_query->id
        ]);
    }

    /**
     * Message tipidagi malumotlar bn ishlash
     * @param $message
     *
     */
    protected function messageHandler($message)
    {
        if ($message->text == t('Buyurtma berish')) {
            $this->setStep('main_categories');
            $this->sendStep();
            $this->sendMainCategories();
            return;
        }

        if ($message->text == t('Orqaga')) {
            $this->sendStep();
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
            $this->sendStep();
            $this->categoryHandler($message);
            return;
        }

        if ($this->bot_user->old_step == "products") {
            $this->sendStep();
            $this->sendProductInfo($message);
            return;
        }

        if ($this->bot_user->old_step == "product_variants") {
            $this->sendStep();
            $this->sendProductVariantInfo($message);
            return;
        }

        if ($this->bot_user->old_step == "product" || $this->bot_user->old_step == "product_variant") {
            if ($message->text == t('Savatcha')) {

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
                $this->sendMainCategories();
            }
            return;
        }

//        $this->mainMenu();
    }

    /**
     * Cart update
     * @param $callback_query
     */
    protected function updateCartInfo($callback_query)
    {

        if (!$this->getCart()) {
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
        $this->setStep('product_variant', strval($product_variant->id));
        $this->sendProductDetail($product_variant);
    }

    /**
     * Mahsulot haqida malumot yuborish
     * @param $message
     */
    protected function sendProductInfo($message)
    {
        $product = Product::findOne(['name' => $message->text]);
        if ($product->productVariants) {
            $this->setStep('product_variants', strval($product->id));
            $this->telegram()->sendMessage([
                'text' => $message->text,
                'chat_id' => $this->bot_user->user_id,
                'parse_mode' => "html",
                'reply_markup' => json_encode([
                    'keyboard' => $this->generateButtons($product->productVariants),
                    'resize_keyboard' => true
                ])
            ]);
        } else {
            $this->setStep('product', strval($product->id));
            $this->sendProductDetail($product);
        }

    }


    protected function sendProductDetail($product)
    {
        $this->telegram()->sendMessage([
            'text' => $product->name,
            'chat_id' => $this->bot_user->user_id,
            'parse_mode' => "html",
            'reply_markup' => json_encode([
                'keyboard' => [
                    [['text' => 1], ['text' => 2], ['text' => 3]],
                    [['text' => 4], ['text' => 5], ['text' => 6]],
                    [['text' => 7], ['text' => 8], ['text' => 9]],
                    [['text' => t('Savatcha')], ['text' => t('Orqaga')]],
                ],
                'resize_keyboard' => true
            ])
        ]);
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
            $this->setStep('products', strval($category->id));
            $this->sendProducts($category);
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
            'text' => "Kategoriyalar",
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
            ]);
            if (!$bot_user->save()) {
                var_dump($bot_user->errors);
            }
        }

        $this->bot_user = $bot_user;
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
                ]) . " Your step: " . $this->bot_user->old_step,
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

    protected function getCart()
    {
        return Cart::find()
            ->andWhere([
                'bot_id' => $this->bot->id,
                'bot_user_id' => $this->bot_user->id,
            ])->all();
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

}


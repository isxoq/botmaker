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

use frontend\models\api\Category;
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

    public $bot;
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


        $this->set_main_variables($from, $bot_id);


        if ($message) {
            $this->messageHandler($message);
            return;
        }

        $this->mainMenu();


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
        }

        if ($message->text == t('Orqaga')) {
            $this->sendStep();
            $this->bot_backward();
        }

        $this->mainMenu();
    }

    /**
     * Botda orqaga qaytish
     *
     */
    protected function bot_backward()
    {
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

    protected function sendMainCategories()
    {

        $mainCategories = Category::find()
            ->andWhere(['bot_id' => $this->bot->id])
//            ->andWhere(['=', 'parent_id', null])
            ->all();


        $keys = [];
        if ($mainCategories) {
            if (count($mainCategories) % 2 == 0) {
                for ($i = 0; $i < count($mainCategories); $i += 2) {
                    $keys[] = [['text' => $mainCategories[$i]->name], ['text' => $mainCategories[$i + 1]]];
                }
            } else {
                $keys[] = [['text' => $mainCategories[0]->name]];

                if (count($mainCategories) > 2) {
                    for ($i = 1; $i < count($mainCategories); $i += 2) {
                        $keys[] = [['text' => $mainCategories[$i]->name], ['text' => $mainCategories[$i + 1]]];
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
    protected function set_main_variables($from, $bot_id)
    {

        $this->bot = TelegramBot::findOne(['bot_id' => $bot_id]);
        $bot_user = BotUser::findOne(['user_id' => $from->id]);


        if (!$bot_user) {
            $bot_user = new BotUser([
                'bot_id' => $this->bot->id,
                'last_action_date' => time(),
                'user_id' => $from->id,
                'username' => $from->username,
                'full_name' => $from->first_name . " " . $from->last_name,
            ]);
            $bot_user->save();
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
        $this->bot_user->save();
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
}


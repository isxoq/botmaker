<?php

namespace backend\modules\payme\components;
/*
Project Name: kontrol.loc
File Name: PaymeButton.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/7/2021 8:33 AM
*/


use yii\base\Widget;

class PaymeButton extends Widget
{
    public $params = "";
    public $merchant = "";
    public $order_id = "";
    public $amount = "";
    public $title = "";
    public $class = "btn btn-primary";

    public function init()
    {
        $this->merchant = \Yii::$app->params['paycomConfig']['merchant_id'];
        $this->amount = $this->amount * 100;

        parent::init(); // TODO: Change the autogenerated stub
    }

    public function run()
    {
        $lang = \Yii::$app->language;
        $html = <<<HTML


<form method="POST" target="_blank" action="https://checkout.paycom.uz/">

    <!-- Идентификатор WEB Кассы -->
    <input type="hidden" name="merchant" value="$this->merchant"/>

    <!-- Сумма платежа в тийинах -->
    <input type="hidden" name="amount" value="$this->amount"/>

    <!-- Поля Объекта Account -->
    <input type="hidden" name="account[order_id]" value="$this->order_id"/>

    <!-- ==================== НЕОБЯЗАТЕЛЬНЫЕ ПОЛЯ ====================== -->
    <!-- Язык. Доступные значения: ru|uz|en
         Другие значения игнорируются
         Значение по умолчанию ru -->
    <input type="hidden" name="lang" value="$lang"/>

    <!-- Валюта. Доступные значения: 643|840|860|978
         Другие значения игнорируются
         Значение по умолчанию 860
         Коды валют в ISO формате
         643 - RUB
         840 - USD
         860 - UZS
         978 - EUR -->
    <input type="hidden" name="currency" value="860"/>

    <!-- URL возврата после оплаты или отмены платежа.
         Если URL возврата не указан, он берется из заголовка запроса Referer.
         URL возврата может содержать параметры, которые заменяются Paycom при запросе.
         Доступные параметры для callback:
         :transaction - id транзакции или "null" если транзакцию не удалось создать
         :account.{field} - поля объекта Account
         Пример: https://your-service.uz/paycom/:transaction -->
    <!--    <input type="hidden" name="callback" value="{url возврата после платежа}"/>-->

    <!-- Таймаут после успешного платежа в миллисекундах.
         Значение по умолчанию 15
         После успешной оплаты, по истечении времени callback_timeout
         производится перенаправление пользователя по url возврата после платежа -->
    <!--    <input type="hidden" name="callback_timeout" value="{miliseconds}"/>-->

    <!-- Выбор платежного инструмента Paycom.
         В Paycom доступна регистрация несколько платежных
         инструментов. Если платёжный инструмент не указан,
         пользователю предоставляется выбор инструмента оплаты.
         Если указать id определённого платежного инструмента -
         пользователь перенаправляется на указанный платежный инструмент. -->
    <!--    <input type="hidden" name="payment" value="{payment_id}"/>-->

    <!-- Описание платежа
         Для описания платежа доступны 3 языка: узбекский, русский, английский.
         Для описания платежа на нескольких языках следует использовать
         несколько полей с атрибутом  name="description[{lang}]"
         lang может принимать значения ru|en|uz -->
    <!--    <input type="hidden" name="description" value="{Описание платежа}"/>-->

    <!-- Объект детализации платежа
         Поле для детального описания платежа, например, перечисления
         купленных товаров, стоимости доставки, скидки.
         Значение поля (value) — JSON-строка закодированная в BASE64 -->
    <!--    <input type="hidden" name="detail" value="{JSON объект детализации в BASE64}"/>-->
    <!-- ================================================================== -->

    <button class="$this->class" type="submit">$this->title</button>
</form>


HTML;


        return $html;
    }
}

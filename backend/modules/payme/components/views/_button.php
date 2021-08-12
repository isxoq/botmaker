<?php
/*
Project Name: kontrol.loc
File Name: _button.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/7/2021 9:04 AM
*/


?>

<form method="POST" action="https://checkout.paycom.uz/">

    <!-- Идентификатор WEB Кассы -->
    <input type="hidden" name="merchant" value="<?= $merchant ?>"/>

    <!-- Сумма платежа в тийинах -->
    <input type="hidden" name="amount" value="<?= 100 * $amount ?>"/>

    <!-- Поля Объекта Account -->
    <input type="hidden" name="account['order_id']" value="<?= $order_id ?>"/>

    <!-- ==================== НЕОБЯЗАТЕЛЬНЫЕ ПОЛЯ ====================== -->
    <!-- Язык. Доступные значения: ru|uz|en
         Другие значения игнорируются
         Значение по умолчанию ru -->
    <input type="hidden" name="lang" value="<?= Yii::$app->language ?>"/>

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

    <button type="submit">Оплатить с помощью <b>Payme</b></button>
</form>
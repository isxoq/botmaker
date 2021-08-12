<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'paycomConfig' => [
        'merchant_id' => '5a8ab9923c65214d660cb77e',
        'login' => 'Paycom',
//        'keyString' => "hV3RaLEaCzBhjsD3soR01QcmdebAgjhdMX5D",
        'keyString' => "%KNfIkt1m1YEfgx9WEWDnXiHaUVZ6PY#aeCE", //test

        'db' => [
            'host' => 'localhost',
            'database' => 'botmaker',
            'username' => 'root',
            'password' => 'root',
        ],

    ]
];

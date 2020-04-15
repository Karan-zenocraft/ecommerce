<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=ecommerce',
            'username' => 'root',
            'password' => 'Zenocraft@123',
            'charset' => 'utf8',
        ],
        'assetManager' => [
            'bundles' => [
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false, // do not load bootstrap assets for a specific asset bundle
                ],
            ],
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
// send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
//'useFileTransport' => false,//to send mails to real email addresses else will get stored in your mail/runtime folder
            //comment the following array to send mail using php's mail function
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'stableapp12@gmail.com',
                'password' => 'Zenocraft@123',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'cm' => [ // bad abbreviation of "CashMoney"; not sustainable long-term
            'class' => 'app/components/CashMoney', // note: this has to correspond with the newly created folder, else you'd get a ReflectionError

            // Next up, we set the public parameters of the class
            'client_id' => 'ASBZA0Yx355sCWCSO7cOrJRqJeQc7WvwE8M1V2i5lflPtvUYNjkS-YDQOyD3c2DdBGtFYXrz_dsBwr_U',
            'client_secret' => 'EArZoxY5krsdOaqkInKveE369O-k2O6bU57fXgG5aWOjlKY9xnrsd5wnd9i7L3Z_ZjQ3iZfmpKGkP7kK',
            'isProduction' => false,
            'config' => [
                'mode' => 'sandbox', // 'sandbox' (development mode) or 'live' (production mode)
            ],
            // You may choose to include other configuration options from PayPal
            // as they have specified in the documentation
        ],
        'onesignal' => [
            'class' => '\rocketfirm\onesignal\OneSignal',
            'appId' => 'ONESIGNAL_APP_ID',
            'apiKey' => 'ONESIGNAL_API_KEY',
        ],
        /*     'pdf' => [
    'class' => Pdf::classname(),
    'format' => Pdf::FORMAT_A4,
    'orientation' => Pdf::ORIENT_PORTRAIT,
    'destination' => Pdf::DEST_DOWNLOAD,
    'mode' => MODE_UTF8,
    'tempPath' => Yii::$app->getAlias('@app/runtime/mpdf'),
    // refer settings section for all configuration options
    ],*/
    ],
    'modules' => [

        'paypal' => [
            'class' => PaypalModule::class,
            'paypalRoles' => ['admin'],
            'showTitles' => false,
        ],

    ],
];

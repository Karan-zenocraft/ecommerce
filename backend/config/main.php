<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\Users',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'scriptUrl' => ($_SERVER['HTTP_HOST'] == "localhost") ? '/ecommerce/admin' : '/ecommerce/admin',
            'rules' => [
                "dashboard" => "site/index",
                "create-user" => "users/create",
                "update-user/<id>" => "users/update",
                "manage-users" => "users/index",
                "delete-user/<id>" => "users/delete",
                "create-category" => "categories/create",
                "update-category/<id>" => "categories/update",
                "manage-categories" => "categories/index",
                "delete-category/<id>" => "categories/delete",
                "manage-products" => "products/index",
                "create-subcategory/<cid>" => "sub-categories/create",
                "update-subcategory/<cid>/<id>" => "categories/update",
                "manage-subcategories/<cid>" => "categories/index",
                "delete-subcategory/<cid>/<id>" => "categories/delete",

            ],
        ],
        'request' => [
            'baseUrl' => ($_SERVER['HTTP_HOST'] == "localhost") ? '/ecommerce/admin' : '/ecommerce/admin',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'pbB0NvlmxlWRk7XFCN_7XUC2uvX0vyCD',
        ],

    ],
    'params' => $params,
];

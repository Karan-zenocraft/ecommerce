<?php
return [
    'adminEmail' => 'testingforproject0@gmail.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'site_url' => stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' . $_SERVER['HTTP_HOST'] : 'http://' . $_SERVER['HTTP_HOST'],
    'root_url' => stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' . $_SERVER['HTTP_HOST'] : 'http://' . $_SERVER['HTTP_HOST'] . "/ecommerce",
    'login_url' => '/ecommerce/admin/login',
    'frontend_login_url' => '/ecommerce/login',
    'user.passwordResetTokenExpire' => 3600,
    'userroles' => [
        'super_admin' => '1',
        'admin' => '2',
        'user' => '3',
    ],
    'user_status' => array('1' => 'Active', '0' => 'In-Active'),
    'user_status_value' => array('active' => '1', 'in_active' => '0'),
    'gender' => [
        '1' => 'Female',
        '2' => 'Male',
    ],
    'device_type_value' => ["1" => "android", "2" => "ios"],
    'bsVersion' => '4.x',
    'bsDependencyEnabled' => false,
    'super_admin_role_id' => '1',
    'administrator_role_id' => '2',
    'action' => ["1" => "delete", "2" => "archive", "3" => "un_archive"],
];

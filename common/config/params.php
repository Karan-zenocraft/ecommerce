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
    'is_approve' => ['0' => 'Waiting', '1' => "Approve", "2" => "Decline"],
    'is_approve_value' => ['wait' => '0', 'true' => "1", "false" => "2"],
    'is_approve_admin' => ['1' => "Approve", "2" => "Decline"],
    'order_status' => ['placed' => '1', 'on_the_way' => '2', 'delievered' => '3', 'cancelled' => '4'],
    'order_status_value' => ['1' => 'Placed', '2' => 'On the Way', '3' => 'Delievered', '4' => 'Cancelled'],
    'payment_type_value' => [
        '1' => 'paypal',
        '2' => 'stripe',
    ],
    'payment_type' => [
        'paypal' => '1',
        'stripe' => '2',
    ],
    'device_type' => ["android" => "1", "ios" => "2"],
    "is_warranty" => ["1"=>"Yes","0"=>"No"]

];

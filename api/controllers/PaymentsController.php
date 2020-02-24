<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;

class PaymentsController extends \yii\base\Controller
{
    // or whatever yours is called

    public function actionMakePayments()
    {
        // or whatever yours is called

        $ch = curl_init();
        $clientId = "ASBZA0Yx355sCWCSO7cOrJRqJeQc7WvwE8M1V2i5lflPtvUYNjkS-YDQOyD3c2DdBGtFYXrz_dsBwr_U";
        $secret = "EArZoxY5krsdOaqkInKveE369O-k2O6bU57fXgG5aWOjlKY9xnrsd5wnd9i7L3Z_ZjQ3iZfmpKGkP7kK";

        curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" . $secret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

        $result = curl_exec($ch);
        $access_token = "";
        if (empty($result)) {
            die("Error: No response.");
        } else {
            $json = json_decode($result);
            $access_token = $json->access_token;
        }

        curl_close($ch);

        $ch1 = curl_init('https://api.sandbox.paypal.com/v1/payments/payment');
        curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $access_token,
        ));

        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);

        $payloadData = '{
  "intent":"sale",
  "redirect_urls":{
    "return_url":"http://localhost/ecommerce",
    "cancel_url":"http://localhost/ecommerce"
  },
  "payer":{
    "payment_method":"paypal"
  },
  "transactions":[
    {
      "amount":{
        "total":"7.47",
        "currency":"USD"
      }
    }
  ]
}';

        curl_setopt($ch1, CURLOPT_POSTFIELDS, $payloadData);
        curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);

        $result = curl_exec($ch1);
        print_r($result);
        $httpStatusCode = curl_getinfo($ch1, CURLINFO_HTTP_CODE);
        print_r($httpStatusCode);
        die();
        curl_close($ch1);
    }

}

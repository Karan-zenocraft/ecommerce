<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;

class PaymentsController extends \yii\base\Controller
{
    // or whatever yours is called

    public function actionMakePaymentsPaypal()
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

    public function actionMakePaypalPayout()
    {
        // or whatever yours is called

        //$access_token = "access_token$sandbox$qt27xx989g9tkhbf$0da8529aa3f41f21b1ac87748e32f1eb";
        $ch = curl_init();
        $clientId = "AdXlVUx_J_ooi908lajfxEC6Ah1iXsRqc84l4j3_lv0-Qy-r8aghEFlBGqPsIzagvt4P-ZwUwqIwozMT";
        $secret = "EOmofrb8O4bXqLIAd13SINvQ1QLBjqhZCRkClgY6DFR2MgobqJpTTjj8YDGfFtQwi9ASROKPsQsD4uuz";

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

        $ch1 = curl_init('https://api.sandbox.paypal.com/v1/payments/payouts');
        curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $access_token,
        ));

        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);

        $payloadData = '{
  "sender_batch_header": {
    "sender_batch_id": "5l5f75ff11616",
    "email_subject": "You have a payout!",
    "email_message": "You have received a payout! Thanks for using our service!"
  },
  "items": [
    {
      "recipient_type": "EMAIL",
      "amount": {
        "value": "15",
        "currency": "USD"
      },
      "note": "Thanks for your patronage",
      "sender_item_id": "item_1",
      "receiver": "sb-cobtt865996@business.example.com"
    },
    {
      "recipient_type": "EMAIL",
      "amount": {
        "value": "10",
        "currency": "USD"
      },
      "note": "Thanks for your support!",
      "sender_item_id": "item_2",
      "receiver": "sb-ehuv1866022@business.example.com"
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
    public function actionMakeBankAccount()
    {
        \Stripe\Stripe::setApiKey("sk_test_q5kNBiI1nvi7EXP6xtTvyPtJ00xQUK5yxl");
        try {
            // first create bank token
            $bankToken = \Stripe\Token::create([
                'bank_account' => [
                    'country' => 'US',
                    'currency' => 'usd',
                    'account_holder_name' => 'Test User',
                    'account_holder_type' => 'individual',
                    'routing_number' => '110000000',
                    'account_number' => '000123456789',
                ],
            ]);
            // second create stripe account
            $stripeAccount = \Stripe\Account::create([
                "type" => "custom",
                "country" => "US",
                "email" => "testingforproject0@gmail.com",
                "business_type" => "individual",
                "requested_capabilities" => ["transfers", "card_payments"],
            ]);
            // third link the bank account with the stripe account
            $bankAccount = \Stripe\Account::createExternalAccount(
                $stripeAccount->id, ['external_account' => $bankToken->id]
            );
            // Fourth stripe account update for tos acceptance
            \Stripe\Account::update(
                $stripeAccount->id, [
                    'tos_acceptance' => [
                        'date' => time(),
                        'ip' => $_SERVER['REMOTE_ADDR'], // Assumes you're not using a proxy
                    ],
                ]
            );
            $response = ["bankToken" => $bankToken->id, "stripeAccount" => $stripeAccount->id, "bankAccount" => $bankAccount->id];
            p($response);
        } catch (\Exception $e) {
            p($e);
        }

        /* $stripeSecret = "sk_test_q5kNBiI1nvi7EXP6xtTvyPtJ00xQUK5yxl";
        \Stripe\Stripe::setApiKey($stripeSecret);
        $acct = \Stripe\Account::create(array(
        "country" => "US",
        "type" => "custom",
        "email" => "testingforproject0@gmail.com",
        "requested_capabilities" => ["transfers", "card_payments"],
        ));
        if ($acct->id) {
        try {

        \Stripe\Stripe::setApiKey("sk_test_q5kNBiI1nvi7EXP6xtTvyPtJ00xQUK5yxl");

        $account = \Stripe\Account::retrieve($acct->id);
        $account->external_accounts->create(array(
        "external_account" => array(
        "object" => "bank_account",
        "account_number" => "00012345",
        "country" => "US",
        "currency" => "usd",
        "routing_number" => "110000000",
        ),
        ));

        $message = 'OK';
        $status = true;

        } catch (\Exception $error) {
        $message = $error->getMessage();
        $status = false;
        }

        $results = (object) array(
        'message' => $message,
        'status' => $status,
        );

        p($results);
        }*/
/*        $ch1 = curl_init('https://api.stripe.com/v1/charges');
curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
'Authorization: Bearer sk_test_q5kNBiI1nvi7EXP6xtTvyPtJ00xQUK5yxl',
));

curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);

$payloadData = '{
"amount":"50",
"currency":"USD",
"description":"test",
"source":"tok_mastercard",
}';
curl_setopt($ch1, CURLOPT_POSTFIELDS, $payloadData);
curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);

$result = curl_exec($ch1);
print_r($result);*/
    }

}

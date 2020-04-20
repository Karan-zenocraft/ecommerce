<?php

namespace api\controllers;

use common\models\Orders;
/* USE COMMON MODELS */
use Yii;
use yii\web\Controller;

/**
 * MainController implements the CRUD actions for APIs.
 */
class CronController extends \yii\base\Controller
{
    public function actionSendPaymentToSellers()
    {
        $date = date("Y-m-d", strtotime("-15 day"));
        $orders = Orders::find()->with(['orderProducts' => function ($q) {
            return $q->with(['product' => function ($q) {
                return $q->with(['seller' => function ($q) {
                    return $q->with('accountDetails');
                }]);
            }]);
        }])->with('orderPayment')->where("DATE(created_at) = '".$date."' AND status != ".Yii::$app->params['order_status']['cancelled'])->asArray()->all();
       
        if (!empty($orders)) {
            foreach ($orders as $key => $order) {
                $orderPayment = $order['orderPayment'];
                $payment_type = $order['payment_type'];
                $orderProducts = $order['orderProducts'];
                foreach ($orderProducts as $key => $orderProduct) {
                    $quantity = $orderProduct['quantity'];
                    $product_id = $orderProduct['product_id'];
                    $order_id = $orderProduct['order_id'];
                    $seller_id = $orderProduct['seller_id'];
                   $payment_arr[$order_id][$product_id]['discounted_price'] = $orderProduct['discounted_price'];
                    $payment_arr[$order_id][$product_id]['product_title'] = $orderProduct['product']['title'];
                    $payment_arr[$order_id][$product_id]['price_to_seller'] = $orderProduct['seller_amount'];
                    $payment_arr[$order_id][$product_id]['seller_id'] = $orderProduct['seller_id'];
                    $payment_arr[$order_id][$product_id]['payment_type'] = $payment_type;
                    $payment_arr[$order_id][$product_id]['accountDetails'] = $orderProduct['product']['seller']['accountDetails'];

                }
            }
               /// p($payment_arr);
                    foreach ($payment_arr as $key_order => $payment) {
                        foreach ($payment as $key_product => $product_detail) {
                        
                    if ($product_detail['payment_type'] == Yii::$app->params['payment_type']['paypal']) {
                        $ch = curl_init();
                        $clientId = "AdI6M9kcjNlm-fCoMJHwiFYkwz3HynVl7fY63ohIr0ESRULeMzlxS3Qi9Gn109UMjhbpV8PWviMIKQgN";
                        $secret = "EO2sBrlqyhbslZZ74rEejDExktaZwrfaHf15EogN6V19Hh4kdaR8tLkZi5Z_Ban7sDTeicaDXwS5wAlw";

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
                            "sender_batch_id": "5l5f75ff1162",
                            "email_subject": "You have a payout!",
                            "email_message": "You have received a payout! Thanks for using our service!"
                          },
                          "items": [
                            {
                              "recipient_type": "EMAIL",
                              "amount": {
                                "value": "' . $product_detail['price_to_seller'] . '",
                                "currency": "USD"
                              },
                              "note": "Thanks for your patronage",
                              "sender_item_id": "' . $product_detail['product_title'] . '",
                              "receiver": "' . $product_detail['accountDetails']['paypal_email'] . '"
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
                    } else {
                        \Stripe\Stripe::setApiKey('sk_test_ZBaRU0wL5z8YaEEPUhY3jzgF00tdHXg5cp');

// Create a PaymentIntent:
                        try {
                            $paymentIntent = \Stripe\PaymentIntent::create([
                                'amount' => $product_detail['price_to_seller'],
                                'currency' => 'usd',
                                'payment_method_types' => ['card'],
                                'transfer_group' => '{ORDER' . $product_detail[$key_order] . '}',

                            ]);
                            p($transfer);
                        } catch (\Exception $e) {
                            p($e);
                        }
                    }
                }

            }
        }
    }
}

<?php
namespace api\controllers;

use common\components\Common;

/* USE COMMON MODELS */
use common\models\Cart;
use common\models\DeviceDetails;
use common\models\EmailFormat;
use common\models\NotificationList;
use common\models\OrderPayment;
use common\models\OrderProducts;
use common\models\Orders;
use common\models\Products;
use common\models\Users;
use Yii;
use yii\web\Controller;

/**
 * MainController implements the CRUD actions for APIs.
 */
class OrdersController extends \yii\base\Controller
{
    public function actionCreateOrder()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'payment_type', 'transaction_id', 'user_address_id');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }
        $requestParam = $amData['request_param'];
        //Check User Status//
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken, $requestParam['user_id']);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            if (!empty($requestParam['products'])) {
                $products = $requestParam['products'];
                foreach ($products as $key => $product) {
                    $amRequiredParamsProducts = array('product_id', 'quantity');
                    $amParamsResultProducts = Common::checkRequestParameterKey($product, $amRequiredParamsProducts);

                    // If any getting error in request paramter then set error message.
                    if (!empty($amParamsResultProducts['error'])) {
                        $amResponse = Common::errorResponse($amParamsResultProducts['error']);
                        Common::encodeResponseJSON($amResponse);
                    }
                    $productVerify = Products::findOne($product['product_id']);
                    if (empty($productVerify)) {
                        $ssMessage = 'This product is not available';
                        $amResponse = Common::errorResponse($ssMessage);
                        Common::encodeResponseJSON($amResponse);
                    }
                }
                $order = new Orders();
                $order->buyer_id = $requestParam['user_id'];
                $order->payment_type = $requestParam['payment_type'];
                $order->user_address_id = $requestParam['user_address_id'];
                $order->status = Yii::$app->params['order_status']['placed'];
                if ($order->save(false)) {
                    $orderPayment = new orderPayment();
                    $orderPayment->order_id = $order->id;
                    $orderPayment->transaction_id = $requestParam['transaction_id'];
                    $orderPayment->save(false);
                    foreach ($products as $key => $product) {
                        $productDetails = Products::findOne($product['product_id']);
                        $orderProducts = new OrderProducts();
                        $orderProducts->order_id = $order->id;
                        $orderProducts->product_id = $product['product_id'];
                        $orderProducts->quantity = $product['quantity'];
                        $orderProducts->discount = $productDetails->discount;
                        $orderProducts->tax = $productDetails->tax;
                        $orderProducts->seller_id = $productDetails->seller_id;
                        $price = $productDetails->price;
                        $price_with_quantity = $product['quantity'] * $price;
                        if (!empty($productDetails->discount) && ($productDetails->discount != "0")) {
                            $discountPrice = ($productDetails->discount / 100) * $price_with_quantity;
                            $discountedPrice = $price_with_quantity - $discountPrice;
                        } else {
                            $discountedPrice = $price_with_quantity;
                        }
                        $ownerCharge = $productDetails->owner_discount;
                        $ownerCharge = $ownerCharge / 100 * $product['quantity'];
                        $charge = $discountedPrice * $ownerCharge;
                        $orderProducts->seller_amount = $discountedPrice - $charge;
                        $orderProducts->discounted_price = $discountedPrice;
                        $orderProducts->actual_price = $price;
                        $orderProducts->price_with_quantity = $price_with_quantity;

                        if (!empty($productDetails->tax) && ($productDetails->tax != "0")) {
                            $sellPrice = $discountedPrice + $productDetails->tax;
                        } else {
                            $sellPrice = $discountedPrice;
                        }
                        $orderProducts->total_price_with_tax_discount = $sellPrice;
                        $orderProducts->save(false);
                        $prices[] = $sellPrice;
                        //$orderProducts->save(false);

                        $addedProducts[] = $orderProducts;
                    }
                    $order->total_amount_paid = array_sum($prices);
                    if ($order->save(false)) {
                        $deviceModel = DeviceDetails::find()->select('device_token,type')->where(['user_id' => $requestParam['user_id']])->one();
                        $device_token = $deviceModel->device_token;
                        $type = $deviceModel->type;
                        $title = "Order Placed successfully";
                        $body = "Your order is " . Yii::$app->params['order_status_value'][$order->status];

                        $status = Common::SendNotificationIOS($device_token, $title, $body);
                        /*  } else {
                        $status = Common::push_notification_android($device_tocken, $title, $body);
                        }*/
                        if (!empty($status)) {
                            $NotificationListModel = new NotificationList();
                            $NotificationListModel->user_id = $requestParam['user_id'];
                            $NotificationListModel->title = $title;
                            $NotificationListModel->body = $body;
                            $NotificationListModel->status = 1;
                            $NotificationListModel->save(false);
                        }
                        $emailformatemodel = EmailFormat::findOne(["title" => 'order_placed', "status" => '1']);
                        if ($emailformatemodel) {

                            //create template file
                            $AreplaceString = array('{username}' => $model->user_name);

                            $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);
                            $ssSubject = $emailformatemodel->subject;
                            //send email for new generated password
                            $ssResponse = Common::sendMail($model->email, Yii::$app->params['adminEmail'], $ssSubject, $body);

                        }
                        Cart::deleteAll(['user_id' => $requestParam['user_id']]);
                        $amReponseParam['order'] = $order;
                        $amReponseParam['orderPayment'] = $orderPayment;
                        $amReponseParam['orderProducts'] = $addedProducts;
                        $ssMessage = 'Order added successfully';
                        $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                    }
                }
            } else {
                $ssMessage = 'Products can not be blank';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionGetMyOrdersList()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $amRequiredParams = array('user_id');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }
        $requestParam = $amData['request_param'];
        //Check User Status//
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken, $requestParam['user_id']);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            $ordersList = Orders::find()->with('orderPayment')->with('orderProducts')->where(['buyer_id' => $requestParam['user_id']])->asArray()->all();
            if (!empty($ordersList)) {
                $amReponseParam = $ordersList;
                $ssMessage = 'Orders List';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $amReponseParam = [];
                $ssMessage = 'Orders List not found';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionCancelOrder()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'order_id');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }
        $requestParam = $amData['request_param'];
        //Check User Status//
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken, $requestParam['user_id']);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            $order = Orders::find()->with('orderPayment')->where(['id' => $requestParam['order_id'], 'buyer_id' => $requestParam['user_id']])->one();
            if (!empty($order)) {
                $date = date("Y-m-d");
                $orderDate = date("Y-m-d", strtotime($order->created_at));
                $order_date = date_create($orderDate);
                $today_date = date_create($date);
                $diff = date_diff($order_date, $today_date);
                $days = $diff->days;
                if ($days <= 2) {
                    if ($order->payment_type == Yii::$app->params['payment_type']['paypal']) {
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

                        $ch1 = curl_init('https://api.sandbox.paypal.com/v2/payments/captures/2GG279541U471931P/refund');
                        curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json',
                            'Authorization: Bearer ' . $access_token,
                        ));

                        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
                        $payloadData = '{
                              "amount": {
                                "value": "' . $order->total_amount_paid . '",
                                "currency_code": "USD"
                              },
                              "invoice_id": "' . $order->orderPayment['transaction_id'] . '",
                              "note_to_payer": "Defective product"
                            }';
                        curl_setopt($ch1, CURLOPT_POSTFIELDS, $payloadData);
                        curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);
                        $result = curl_exec($ch1);
                        p($result);
                        $httpStatusCode = curl_getinfo($ch1, CURLINFO_HTTP_CODE);
                        p($httpStatusCode);
                        die();
                        curl_close($ch1);
                    } else {
                        \Stripe\Stripe::setApiKey('sk_test_ZBaRU0wL5z8YaEEPUhY3jzgF00tdHXg5cp');
                        $refund = \Stripe\Refund::create([
                            'charge' => $order->orderPayment['transaction_id'],
                        ]);
                        p($refund);

                    }

                    $ssMessage = 'Order cancelled successfully.';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                } else {
                    $ssMessage = 'You can cancel order in 2 working days after creation';
                    $amResponse = Common::errorResponse($ssMessage);
                }
            } else {
                $ssMessage = 'Order not found';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionGetSellerProductOrderList()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $amRequiredParams = array('user_id');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }
        $requestParam = $amData['request_param'];
        //Check User Status//
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken, $requestParam['user_id']);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            $sellerProducts = Products::find()->select('GROUP_CONCAT(id) AS product_id')->where(['seller_id' => $requestParam['user_id']])->asArray()->all();
            $seller_products = current($sellerProducts);
            if (!empty($seller_products['product_id'])) {
                $query = "SELECT DISTINCT GROUP_CONCAT(orders.`id`) AS order_id
                FROM `orders`
                LEFT JOIN order_payment
                ON `orders`.id=`order_payment`.order_id
                LEFT JOIN order_products
                ON `orders`.id=`order_products`.order_id
                WHERE `order_products`.product_id IN (" . $seller_products['product_id'] . ")";
                $orders = Yii::$app->db->createCommand($query)->queryAll();
                $orderss = current($orders);
                if (!empty($orderss['order_id'])) {
                    $ordersList = Orders::find()->with('orderPayment')->with('orderProducts')->where("id IN(" . $orderss['order_id'] . ")")->asArray()->all();
                    $amReponseParam = $ordersList;
                    $ssMessage = "Seller Product's Orders List";
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                } else {
                    $amReponseParam = [];
                    $ssMessage = 'Orders List not found';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                }
            } else {
                $amReponseParam = [];
                $ssMessage = 'You have not added any product yet.';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }
}

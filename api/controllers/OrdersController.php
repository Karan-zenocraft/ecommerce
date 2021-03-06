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
                        $productDetails->quantity_in_stock = $productDetails->quantity_in_stock - $product['quantity'];
                        $productDetails->save(false);
                        $prices[] = $sellPrice;
                        //$orderProducts->save(false);

                        $addedProducts[] = $orderProducts;
                    }
                    $order->total_amount_paid = array_sum($prices);
                    if ($order->save(false)) {
                        $deviceModel = DeviceDetails::find()->select('device_token,type')->where(['user_id' => $requestParam['user_id']])->one();
                         if(!empty($deviceModel) && !empty($deviceModel->device_token)){
                        $device_token = $deviceModel->device_token;
                        $type = $deviceModel->type;
                        $title = "Order Placed successfully";
                        $body = "Your order is " . Yii::$app->params['order_status_value'][$order->status];
                        $status = Common::SendNotificationIOS($device_token, $title, $body);
                        $statusArr = json_decode($status);
                        /*  } else {
                        $status = Common::push_notification_android($device_tocken, $title, $body);
                        }*/
                        if (!empty($statusArr) && ($statusArr->success == "1")) {
                            $NotificationListModel = new NotificationList();
                            $NotificationListModel->user_id = $requestParam['user_id'];
                            $NotificationListModel->title = $title;
                            $NotificationListModel->body = $body;
                            $NotificationListModel->status = 1;
                            $NotificationListModel->save(false);
                        }
                    }
                        $emailformatemodel = EmailFormat::findOne(["title" => 'order_placed', "status" => '1']);
                        if ($emailformatemodel && !empty($model->email)) {

                            //create template file
                            $AreplaceString = array('{username}' => $model->user_name);

                            $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);
                            $ssSubject = $emailformatemodel->subject;
                            //send email for new generated password
                            $ssResponse = Common::sendMail($model->email, Yii::$app->params['adminEmail'], $ssSubject, $body);

                        }
                        if (!empty($addedProducts)) {
                            foreach ($addedProducts as $key => $product) {
                                $seller_id = $product['seller_id'];
                                $sellerDetails = Common::get_name_by_id($seller_id, "Users");
                                $product_name = Common::get_name_by_id($product['product_id'], "Products");
                                $deviceModel = DeviceDetails::find()->select('device_token,type')->where(['user_id' => $seller_id])->one();
                                if(!empty($deviceModel) && !empty($deviceModel->device_token)){
                                $device_token = $deviceModel->device_token;
                                $type = $deviceModel->type;
                                $title = "Your Product -" . $product_name . " order";
                                $body = "Your Product -" . $product_name . " is ordered by " . $model->user_name . "";
                                $status = Common::SendNotificationIOS($device_token, $title, $body);
                                $statusArr = json_decode($status);
                                /*  } else {
                                $status = Common::push_notification_android($device_tocken, $title, $body);
                                }*/
                                if (!empty($statusArr) && ($statusArr->success == "1")) {
                                    $NotificationListModel = new NotificationList();
                                    $NotificationListModel->user_id = $seller_id;
                                    $NotificationListModel->title = $title;
                                    $NotificationListModel->body = $body;
                                    $NotificationListModel->status = 1;
                                    $NotificationListModel->save(false);
                                }
                            }
                                $emailformatemodel = EmailFormat::findOne(["title" => 'order_placed_seller', "status" => '1']);
                                if ($emailformatemodel && !empty($sellerDetails->email)) {

                                    //create template file
                                    $AreplaceString = array('{username}' => $sellerDetails->user_name, '{buyer_name}' => $model->user_name, '{product_name}' => $product_name);

                                    $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);
                                    $ssSubject = $emailformatemodel->subject;
                                    //send email for new generated password
                                    $ssResponse = Common::sendMail($sellerDetails->email, Yii::$app->params['adminEmail'], $ssSubject, $body);

                                }
                                # code...
                            }
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
            $ordersList = Orders::find()->with('orderPayment')->with(['orderProducts' => function ($q) {
                return $q->with(['product' => function ($q) {
                    return $q->select('products.id,category_id,subcategory_id,title')->with(['category'=>function($q){
                        return $q->select('id,title');
                    }])->with(['subcategory'=>function($q){
                        return $q->select('id,title');
                    }])->with('productPhotos');
                }]);
            }])->where(['buyer_id' => $requestParam['user_id']])->asArray()->all();
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
            $order = Orders::find()->with('orderPayment')->with('orderProducts')->where(['id' => $requestParam['order_id'], 'buyer_id' => $requestParam['user_id']])->one();

            if (!empty($order)) {
                if ($order->status == Yii::$app->params['order_status']['placed']) {
                    $date = date("Y-m-d");
                    $orderDate = date("Y-m-d", strtotime($order->created_at));
                    $order_date = date_create($orderDate);
                    $today_date = date_create($date);
                    $diff = date_diff($order_date, $today_date);
                    $days = $diff->days;
                    if ($days <= 2) {
                        if ($order->payment_type == Yii::$app->params['payment_type']['paypal']) {
                            $ch = curl_init();
                            $clientId = "AdI6M9kcjNlm-fCoMJHwiFYkwz3HynVl7fY63ohIr0ESRULeMzlxS3Qi9Gn109UMjhbpV8PWviMIKQgN";
                            $secret = 'EO2sBrlqyhbslZZ74rEejDExktaZwrfaHf15EogN6V19Hh4kdaR8tLkZi5Z_Ban7sDTeicaDXwS5wAlw';
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

                            $cURLConnection = curl_init();
                            $header = array(
                                "Content-Type: application/json",
                                "Authorization: Bearer " . $access_token,
                            );
                            curl_setopt($cURLConnection, CURLOPT_URL, 'https://api.sandbox.paypal.com/v1/payments/payment/' . $order->orderPayment['transaction_id']);
                            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $header);

                            $phoneList = curl_exec($cURLConnection);
                            curl_close($cURLConnection);

                            $jsonArrayResponse = json_decode($phoneList);
                            $sale_id = !empty($jsonArrayResponse->transactions[0]) ? $jsonArrayResponse->transactions[0]->related_resources[0]->sale->id : "";
                            if (!empty($sale_id)) {
                                $header = array(
                                    "Content-Type: application/json",
                                    "Authorization: Bearer " . $access_token,
                                );
                                $ch1 = curl_init("https://api.sandbox.paypal.com/v1/payments/sale/" . $sale_id . "/refund");
                                curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch1, CURLOPT_POST, true);
                                curl_setopt($ch1, CURLOPT_POSTFIELDS, '{}');
                                curl_setopt($ch1, CURLOPT_HTTPHEADER, $header);
                                $res = json_decode(curl_exec($ch1));
                                $code = curl_getinfo($ch1, CURLINFO_HTTP_CODE);
                                curl_close($ch1);
                                // if res has a state, retrieve it
                                if (isset($res->state)) {
                                    $state = $res->state;
                                } else {
                                    $state = null; // otherwise, set to NULL
                                }

                                // if we have a state in the response...
                                if ($state == 'completed') {
                                    $order->status = Yii::$app->params['order_status']['cancelled'];
                                    $order->save(false);
                                    $orderProducts = $order->orderProducts;
                                    if (!empty($orderProducts)) {
                                        foreach ($orderProducts as $key => $product) {
                                        $productDetails = Products::findOne($product['product_id']);
                                        $productDetails->quantity_in_stock = $productDetails->quantity_in_stock + $product['quantity'];
                                        $productDetails->save(false);
                                            $seller_id = $product['seller_id'];
                                            $sellerDetails = Common::get_name_by_id($seller_id, "Users");
                                            $product_name = Common::get_name_by_id($product['product_id'], "Products");
                                            $deviceModel = DeviceDetails::find()->select('device_token,type')->where(['user_id' => $seller_id])->one();
                                            $device_token = $deviceModel->device_token;
                                            $type = $deviceModel->type;
                                            $title = "Order cancelled successfully";
                                            $body = "Your product's order is " . Yii::$app->params['order_status_value'][$order->status];
                                            $status = Common::SendNotificationIOS($device_token, $title, $body);
                                            $statusArr = json_decode($status);
                                            /*  } else {
                                            $status = Common::push_notification_android($device_tocken, $title, $body);
                                            }*/
                                            if (!empty($statusArr) && ($statusArr->success == "1")) {
                                                $NotificationListModel = new NotificationList();
                                                $NotificationListModel->user_id = $seller_id;
                                                $NotificationListModel->title = $title;
                                                $NotificationListModel->body = $body;
                                                $NotificationListModel->status = 1;
                                                $NotificationListModel->save(false);
                                            }
                                            $emailformatemodel = EmailFormat::findOne(["title" => 'order_cancelled', "status" => '1']);
                                            if ($emailformatemodel && !empty($sellerDetails->email)) {

                                                //create template file
                                                $AreplaceString = array('{username}' => $sellerDetails->user_name, '{buyer_name}' => $model->user_name, '{product_name}' => $product_name);

                                                $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);
                                                $ssSubject = $emailformatemodel->subject;
                                                //send email for new generated password
                                                $ssResponse = Common::sendMail($sellerDetails->email, Yii::$app->params['adminEmail'], $ssSubject, $body);

                                            }
                                            # code...
                                        }
                                    }
                                    $ssMessage = 'Order cancelled successfully.';
                                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                                    // the refund was successful
                                } else {
                                    // the refund failed
                                    $errorName = $res->name; // ex. 'Transaction Refused.'
                                    $errorReason = $res->message; // ex. 'The requested transaction has already been fully refunded.'
                                    $ssMessage = $errorReason;
                                    $amResponse = Common::errorResponse($ssMessage);
                                }
                            } else {
                                $ssMessage = 'Something went wrong please try again later';
                                $amResponse = Common::errorResponse($ssMessage);
                            }
                        } else {
                            \Stripe\Stripe::setApiKey('sk_test_ZBaRU0wL5z8YaEEPUhY3jzgF00tdHXg5cp');
                            $refund = \Stripe\Refund::create([
                                'charge' => $order->orderPayment['transaction_id'],
                            ]);
                            if ($refund) {
                                $order->status = Yii::$app->params['order_status']['cancelled'];
                                $order->save(false);
                                $deviceModel = DeviceDetails::find()->select('device_token,type')->where(['user_id' => $requestParam['user_id']])->one();
                                $orderProducts = $order->orderProducts;
                                if (!empty($orderProducts)) {
                                    foreach ($orderProducts as $key => $product) {
                                        $seller_id = $product['seller_id'];
                                        $sellerDetails = Common::get_name_by_id($seller_id, "Users");
                                        $product_name = Common::get_name_by_id($product['product_id'], "Products");
                                        $deviceModel = DeviceDetails::find()->select('device_token,type')->where(['user_id' => $seller_id])->one();
                                        $device_token = $deviceModel->device_token;
                                        $type = $deviceModel->type;
                                        $title = "Order cancelled successfully";
                                        $body = "Your product's order is " . Yii::$app->params['order_status_value'][$order->status];
                                        $status = Common::SendNotificationIOS($device_token, $title, $body);
                                        $statusArr = json_decode($status);
                                        /*  } else {
                                        $status = Common::push_notification_android($device_tocken, $title, $body);
                                        }*/
                                        if (!empty($statusArr) && ($statusArr->success == "1")) {
                                            $NotificationListModel = new NotificationList();
                                            $NotificationListModel->user_id = $seller_id;
                                            $NotificationListModel->title = $title;
                                            $NotificationListModel->body = $body;
                                            $NotificationListModel->status = 1;
                                            $NotificationListModel->save(false);
                                        }
                                        $emailformatemodel = EmailFormat::findOne(["title" => 'order_cancelled', "status" => '1']);
                                        if ($emailformatemodel && !empty($sellerDetails->email)) {

                                            //create template file
                                            $AreplaceString = array('{username}' => $sellerDetails->user_name, '{buyer_name}' => $model->user_name, '{product_name}' => $product_name);

                                            $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);
                                            $ssSubject = $emailformatemodel->subject;
                                            //send email for new generated password
                                            $ssResponse = Common::sendMail($sellerDetails->email, Yii::$app->params['adminEmail'], $ssSubject, $body);

                                        }
                                        # code...
                                    }
                                }
                                $ssMessage = 'Order cancelled successfully.';
                                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                            } else {
                                $ssMessage = "Something went wrong";
                                $amResponse = Common::errorResponse($ssMessage);
                            }

                        }
                    } else {
                        $ssMessage = 'You can cancel order in 2 working days after creation';
                        $amResponse = Common::errorResponse($ssMessage);
                    }
                } else {
                    $ssMessage = 'Order is already cancelled';
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
                    $ordersList = Orders::find()->with('orderPayment')->with(['orderProducts' => function ($q) {
                        return $q->with(['product' => function ($q) {
                            return $q->select('products.id,title')->with('productPhotos');
                        }]);
                    }])->with(['buyer' => function ($q) {
                        return $q->select("users.id,users.user_name");
                    }])->where("id IN(" . $orderss['order_id'] . ")")->asArray()->all();
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

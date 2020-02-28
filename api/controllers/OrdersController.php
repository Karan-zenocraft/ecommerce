<?php
namespace api\controllers;

use common\components\Common;

/* USE COMMON MODELS */
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
    public function actionAddOrder()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'payment_type', 'discount', 'tax', 'transaction_id');
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
                    } else {
                        p($productVerify);
                    }
                }
                $order = new Orders();
                $order->buyer_id = $requestParam['user_id'];
                $order->payment_type = $requestParam['payment_type'];
                $order->tax = $requestParam['tax'];
                $order->status = Yii::$app->params['order_status']['placed'];
                if ($order->save(false)) {
                    $orderPayment = new orderPayment();
                    $orderPayment->order_id = $order->id;
                    $orderPayment->transaction_id = $requestParam['transaction_id'];
                    $orderPayment->save(false);
                    foreach ($products as $key => $product) {
                        $orderProducts = new OrderProducts();
                        $orderProducts->order_id = $order->id;
                        $orderProducts->product_id = $product['product_id'];
                        $orderProducts->quantity = $product['quantity'];
                        $orderProducts->save(false);
                        $addedProducts[] = $orderProducts;
                    }
                    $amReponseParam = $order;
                    $amReponseParam['orderPayment'] = $orderPayment;
                    $amReponseParam['orderProducts'] = $addedProducts;
                    $ssMessage = 'Order added successfully';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
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
}

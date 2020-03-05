<?php
namespace api\controllers;

use common\components\Common;

/* USE COMMON MODELS */
use common\models\Cart;
use common\models\ProductPhotos;
use common\models\Users;
use common\models\Wishlist;
use Yii;
use yii\web\Controller;

/**
 * MainController implements the CRUD actions for APIs.
 */
class CartController extends \yii\base\Controller
{
    public function actionGetCartProductsList()
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
            $snCartList = Cart::find()->with('product')->where(['user_id' => $requestParam['user_id']])->asArray()->all();

            $amReponseParam = [];
            if (!empty($snCartList)) {
                array_walk($snCartList, function ($arr) use (&$amResponseData) {
                    $ttt = $arr;
                    $ttt['product_title'] = !empty($ttt['product']) ? $ttt['product']['title'] : "";
                    $ttt['product_price'] = !empty($ttt['product']) ? $ttt['product']['price'] : "";
                    $ttt['product_price'] = !empty($ttt['product']) ? $ttt['product']['price'] : "";
                    $ttt['product_is_rent'] = !empty($ttt['product']['is_rent']) ? $ttt['product']['is_rent'] : "0";
                    $ttt['product_rent_price'] = !empty($ttt['product']['rent_price']) ? $ttt['product']['rent_price'] : "";
                    $ttt['product_rent_price_duration'] = !empty($ttt['product']['rent_price_duration']) ? $ttt['product']['rent_price_duration'] : "";
                    $ttt['lat'] = !empty($ttt['product']) ? $ttt['product']['lat'] : "";
                    $ttt['longg'] = !empty($ttt['product']) ? $ttt['product']['longg'] : "";
                    $ttt['location_address'] = !empty($ttt['product']) ? $ttt['product']['location_address'] : "";
                    $ttt['city'] = !empty($ttt['product']) ? $ttt['product']['city'] : "";
                    $ttt['product_photos'] = ProductPhotos::find()->where(['product_id' => $ttt['product_id']])->asArray()->all();
                    unset($ttt['product']);
                    $amResponseData[] = $ttt;
                    return $amResponseData;
                });
                $amReponseParam = $amResponseData;
                $ssMessage = 'Cart Product List';
            } else {
                $ssMessage = 'Your cart is Empty';
            }
            $amResponse = Common::successResponse($ssMessage, $amReponseParam);
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionAddProductToCart()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'product_id', 'quantity');
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
            $CModel = Cart::find()->where(['user_id' => $requestParam['user_id'], "product_id" => $requestParam['product_id']])->one();
            if (!empty($CModel)) {
                $ssMessage = 'This product already added on your cart';
                $amResponse = Common::errorResponse($ssMessage);
            } else {
                $cartModel = new Cart();
                $cartModel->user_id = $requestParam['user_id'];
                $cartModel->product_id = $requestParam['product_id'];
                $cartModel->quantity = $requestParam['quantity'];
                $cartModel->save(false);
                $amReponseParam = $cartModel;
                $ssMessage = 'Product successfully added to your cart.';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionAddProductToCartFromWishlist()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'wishlist_id', 'quantity');
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
            $WishListModel = Wishlist::find()->where(["id" => $requestParam['wishlist_id'], "user_id" => $requestParam['user_id']])->one();
            if (!empty($WishListModel)) {

                $CModel = Cart::find()->where(['user_id' => $WishListModel->user_id, "product_id" => $WishListModel->product_id])->one();
                if (!empty($CModel)) {
                    $ssMessage = 'This product already added on your cart';
                    $amResponse = Common::errorResponse($ssMessage);
                } else {
                    $cartModel = new Cart();
                    $cartModel->user_id = $WishListModel->user_id;
                    $cartModel->product_id = $WishListModel->product_id;
                    $cartModel->quantity = $requestParam['quantity'];
                    $cartModel->save(false);
                    $amReponseParam = $cartModel;
                    $WishListModel->delete();
                    $ssMessage = 'Product successfully added to your cart.';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                }

            } else {
                $ssMessage = 'Invalid Wishlist Id.';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionRemoveProductFromCart()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'id');
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
            if ($requestParam['id'] == 0) {
                Cart::deleteAll(['user_id' => $requestParam['user_id']]);
                $ssMessage = 'Your cart is empty now.';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $CartModel = Cart::find()->where(["id" => $requestParam['id'], 'user_id' => $requestParam['user_id']])->one();
                if (!empty($CartModel)) {
                    $amReponseParam = [];
                    $CartModel->delete();
                    $ssMessage = 'This Product have removed from your Cart';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                } else {
                    $ssMessage = 'Invalid cart id';
                    $amResponse = Common::errorResponse($ssMessage);
                }

            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }
}

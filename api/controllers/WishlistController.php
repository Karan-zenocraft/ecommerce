<?php
namespace api\controllers;

use common\components\Common;

/* USE COMMON MODELS */
use common\models\ProductPhotos;
use common\models\Users;
use common\models\Wishlist;
use Yii;
use yii\web\Controller;

/**
 * MainController implements the CRUD actions for APIs.
 */
class WishlistController extends \yii\base\Controller
{
    public function actionGetWishList()
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
            $snWishList = Wishlist::find()->with('product')->where(['user_id' => $requestParam['user_id']])->asArray()->all();

            $amReponseParam = [];
            if (!empty($snWishList)) {
                array_walk($snWishList, function ($arr) use (&$amResponseData) {
                    $ttt = $arr;
                    $ttt['product_title'] = !empty($ttt['product']) ? $ttt['product']['title'] : "";
                    $ttt['product_price'] = !empty($ttt['product']) ? $ttt['product']['price'] : "";
                    $ttt['product_price'] = !empty($ttt['product']) ? $ttt['product']['price'] : "";
                    $ttt['product_is_rent'] = !empty($ttt['product']['is_rent']) ? $ttt['product']['is_rent'] : "0";
                    $ttt['product_rent_price'] = !empty($ttt['product']['rent_price']) ? $ttt['product']['rent_price'] : "";
                    $ttt['product_rent_price_duration'] = !empty($ttt['product']['rent_price_duration']) ? $ttt['product']['rent_price_duration'] : "";
                    $ttt['product_photos'] = ProductPhotos::find()->where(['product_id' => $ttt['product_id']])->asArray()->all();
                    unset($ttt['product']);
                    $amResponseData[] = $ttt;
                    return $amResponseData;
                });
                $amReponseParam = $amResponseData;
                $ssMessage = 'Wish List';
            } else {
                $ssMessage = 'Wish List not found.';
            }
            $amResponse = Common::successResponse($ssMessage, $amReponseParam);
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionAddProductToWishlist()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'product_id');
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
            $WModel = Wishlist::find()->where(['user_id' => $requestParam['user_id'], "product_id" => $requestParam['product_id']])->one();
            if (!empty($WModel)) {
                $ssMessage = 'This product already added on your wish list';
                $amResponse = Common::errorResponse($ssMessage);
            } else {
                $WishlistModel = new Wishlist();
                $WishlistModel->user_id = $requestParam['user_id'];
                $WishlistModel->product_id = $requestParam['product_id'];
                $WishlistModel->save(false);
                $amReponseParam = $WishlistModel;
                $ssMessage = 'Product successfully added to your wish list.';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionRemoveProductFromWishlist()
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
            $chatListModel = Wishlist::find()->where(["id" => $requestParam['id'], 'user_id' => $requestParam['user_id']])->one();
            if (!empty($chatListModel)) {
                $amReponseParam = [];
                $chatListModel->delete();
                $ssMessage = 'This Product have removed from your wish list';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $ssMessage = 'Invalid wish list id';
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

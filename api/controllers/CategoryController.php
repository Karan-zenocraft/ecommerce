<?php

namespace api\controllers;

use common\components\Common;

/* USE COMMON MODELS */
use common\models\Category;
use common\models\Users;
use Yii;
use yii\web\Controller;

/**
 * MainController implements the CRUD actions for APIs.
 */
class CategoryController extends \yii\base\Controller
{
    /*
     * Function : GetProductsList()
     * Description : Get Product List
     * Request Params : user_id
     * Response Params : user's details
     * Author : Rutusha Joshi
     */

    /* public function actionGetCategoryList()
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
    $snCategoriesList = Categories::find()->asArray()->all();
    $amReponseParam = [];
    if (!empty($snCategoriesList)) {
    $amReponseParam = $snCategoriesList;
    $ssMessage = 'Categories List';
    } else {
    $ssMessage = 'Categories not found.';
    }
    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
    } else {
    $ssMessage = 'Invalid User.';
    $amResponse = Common::errorResponse($ssMessage);
    }
    // FOR ENCODE RESPONSE INTO JSON //
    Common::encodeResponseJSON($amResponse);
    }

    public function actionGetSubCategoryList()
    {
    //Get all request parameter
    $amData = Common::checkRequestType();
    $amResponse = $amReponseParam = [];
    // Check required validation for request parameter.
    $amRequiredParams = array('user_id', 'category_id');
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
    $validateCategory = Categories::findOne($requestParam['category_id']);
    if (!empty($validateCategory)) {
    $amReponseParam = [];
    $snSubCategoriesList = SubCategories::find()->where(['category_id' => $requestParam['category_id']])->asArray()->all();
    if (!empty($snSubCategoriesList)) {
    $amReponseParam = $snSubCategoriesList;
    $ssMessage = 'Sub Categories List';
    } else {
    $ssMessage = 'Sub Categories not found.';
    }
    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
    } else {
    $ssMessage = 'Invalid category_id.';
    $amResponse = Common::errorResponse($ssMessage);
    }
    } else {
    $ssMessage = 'Invalid User.';
    $amResponse = Common::errorResponse($ssMessage);
    }
    // FOR ENCODE RESPONSE INTO JSON //
    Common::encodeResponseJSON($amResponse);
    }*/
    public function actionGetCategoryList()
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
        $snCategoriesList = [];
        if (!empty($model)) {
            $snCategoriesList = Category::find()->with('categories')->where("parent_id is NULL")->asArray()->all();
            $amReponseParam = [];
            if (!empty($snCategoriesList)) {
                $amReponseParam = $snCategoriesList;
                $ssMessage = 'Categories List';
            } else {
                $ssMessage = 'Categories not found.';
            }
            $amResponse = Common::successResponse($ssMessage, $amReponseParam);
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }
}

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
                array_walk($snCategoriesList, function ($arr) use (&$amResponseData) {
                    $ttt = $arr;
                    $ttt['parent_id'] = !empty($ttt['parent_id']) ? $ttt['parent_id'] : "";
                    $ttt['photo'] = !empty($ttt['photo']) ? $ttt['photo'] : "";
                    if (!empty($ttt['categories'])) {
                        array_walk($ttt['categories'], function ($arr) use (&$amResponseDataCategories) {
                            $ttt = $arr;
                            $ttt['photo'] = !empty($ttt['photo']) ? $ttt['photo'] : "";
                            $amResponseDataCategories[] = $ttt;
                            return $amResponseDataCategories;
                        });
                        $ttt['categories'] = $amResponseDataCategories;
                    }
                    $amResponseData[] = $ttt;
                    return $amResponseData;
                });
                $amReponseParam = $amResponseData;
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

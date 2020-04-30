<?php
namespace api\controllers;

use common\components\Common;

/* USE COMMON MODELS */
use common\models\Brands;
use common\models\Users;
use Yii;
use yii\web\Controller;

/**
 * MainController implements the CRUD actions for APIs.
 */
class BrandsController extends \yii\base\Controller
{
    public function actionGetBrandList()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
       
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
            if(!empty($requestParam['parent_category_id']) && !empty($requestParam['sub_category_id'])){
                $snBrandsList = Brands::find()->where(['parent_category_id' => $requestParam['parent_category_id'], "sub_category_id" => $requestParam['sub_category_id']])->asArray()->all();
            }else{
                $snBrandsList = Brands::find()->asArray()->all();
            }
            $amReponseParam = [];
            if (!empty($snBrandsList)) {
                $amReponseParam = $snBrandsList;
                $ssMessage = 'Brands List';
            } else {
                $ssMessage = 'Brands not found.';
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

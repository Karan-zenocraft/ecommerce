<?php
namespace api\controllers;

use common\components\Common;

/* USE COMMON MODELS */
use common\models\Advertise;
use common\models\Users;
use Yii;
use yii\web\Controller;

/**
 * MainController implements the CRUD actions for APIs.
 */
class AdvertiseController extends \yii\base\Controller
{
    public function actionGetAdvertiseList()
    {
        //Get all request parameter
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
        $amReponseParam = [];
        if (!empty($model)) {
            $snAdvertiseList = Advertise::find()->asArray()->all();
            if (!empty($snAdvertiseList)) {
                foreach ($snAdvertiseList as $key => $Advertise) {

                    $Advertise['image'] = Yii::$app->params['root_url'] . "/uploads/advertise/" . $Advertise['image'];
                    $Advertise['url'] = !empty($Advertise['url']) ? $Advertise['url'] : "";
                    $ads[] = $Advertise;
                }
                $amReponseParam = $ads;
                $ssMessage = 'Advertisement List';
            } else {
                $ssMessage = 'Advertises not found.';
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

<?php

namespace api\controllers;

use common\components\Common;
use common\models\DeviceDetails;
use common\models\NotificationList;
/* USE COMMON MODELS */
use common\models\Users;
use Yii;
use yii\web\Controller;

/**
 * MainController implements the CRUD actions for APIs.
 */
class NotificationController extends \yii\base\Controller
{
    public function actionGetNotificationList()
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
        $model = Users::findOne($snUserId);
        if (!empty($model)) {
            $notificationList = NotificationList::find()->where(["user_id" => $requestParam['user_id']])->asArray()->All();
            if (!empty($notificationList)) {
                $ssMessage = 'Notifications List';
                $amReponseParam = $notificationList;
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $ssMessage = 'Notifications not found';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }
    public function actionSendChatNotification()
    {
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'message_title', 'message_body');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        //Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        //  $authToken = Common::get_header('auth_token');
        //Common::checkAuthentication($authToken, $requestParam['user_id']);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne($snUserId);
        if (!empty($model)) {
            $deviceModel = DeviceDetails::find()->select('device_token,type')->where(['user_id' => $requestParam['user_id']])->one();
            if (!empty($deviceModel)) {
                $device_token = $deviceModel->device_token;
                $type = $deviceModel->type;
                $title = $requestParam['message_title'];
                $body = $requestParam['message_body'];
                $status = Common::SendNotificationIOS($device_token, $title, $body);
                $statusArr = json_decode($status);
                /*  } else {
                $status = Common::push_notification_android($device_tocken, $title, $body);
                }*/
                p($statusArr);
                if (!empty($statusArr) && ($statusArr->success == "1")) {
                    $ssMessage = 'Notification sent successfully';
                    $amReponseParam = [];
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                } else {
                    $ssMessage = 'Something went wrong';
                    $amResponse = Common::errorResponse($ssMessage);
                }

            } else {
                $ssMessage = 'Device not found';
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

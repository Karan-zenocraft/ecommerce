<?php
namespace api\controllers;

/* USE COMMON MODELS */
use common\components\Common;
use Yii;
use yii\web\Controller;

/**
 * MainController implements the CRUD actions for APIs.
 */
class NotificationController extends \yii\base\Controller
{
    public function actionSend()
    {
        $response = $this->sendMessage();
        $return["allresponses"] = $response;
        $return = json_encode($return);
        print("\n\nJSON received:\n");
        print($return);
        print("\n");
    }
    public function sendMessage()
    {
        $content = array(
            "en" => 'Testing Message',
        );

        $fields = array(
            'app_id' => "e6dee169-93d8-411f-a737-b4a62bce8247",
            'included_segments' => array('All'),
            'include_player_ids' => array(),
            'data' => array("foo" => "bar"),
            'large_icon' => "ic_launcher_round.png",
            'contents' => $content,
        );

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
    public function actionTest()
    {
        Common::SendNotificationIOS();
    }

}

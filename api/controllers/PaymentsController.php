<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;

class PaymentsController extends \yii\base\Controller
{
    // or whatever yours is called

    public function actionMakePaymentsPaypal()
    {
        // or whatever yours is called

        $ch = curl_init();
        $clientId = "ASBZA0Yx355sCWCSO7cOrJRqJeQc7WvwE8M1V2i5lflPtvUYNjkS-YDQOyD3c2DdBGtFYXrz_dsBwr_U";
        $secret = "EArZoxY5krsdOaqkInKveE369O-k2O6bU57fXgG5aWOjlKY9xnrsd5wnd9i7L3Z_ZjQ3iZfmpKGkP7kK";

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

        $ch1 = curl_init('https://api.sandbox.paypal.com/v1/payments/payment');
        curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $access_token,
        ));

        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);

        $payloadData = '{
  "intent":"sale",
  "redirect_urls":{
    "return_url":"http://localhost/ecommerce",
    "cancel_url":"http://localhost/ecommerce"
  },
  "payer":{
    "payment_method":"paypal"
  },
  "transactions":[
    {
      "amount":{
        "total":"7.47",
        "currency":"USD"
      }
    }
  ]
}';

        curl_setopt($ch1, CURLOPT_POSTFIELDS, $payloadData);
        curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);

        $result = curl_exec($ch1);
        print_r($result);
        $httpStatusCode = curl_getinfo($ch1, CURLINFO_HTTP_CODE);
        print_r($httpStatusCode);
        die();
        curl_close($ch1);
    }
    public function makePayment()
    {
        $ppemail = "rutusha.joshi@zenocraft.com"
        $payLoad = array();

//prepare the receivers
        $receiverList = array();
        $counter = 0;
        $receiverList["receiver"][$counter]["amount"] = $r["withdrawalAmount"];
        $receiverList["receiver"][$counter]["email"] = $r["paypalEmail"];
        $receiverList["receiver"][$counter]["paymentType"] = "SERVICE"; //this could be SERVICE or PERSONAL (which makes it free!)
        $receiverList["receiver"][$counter]["invoiceId"] = $r["withdrawalID"]; //NB that this MUST be unique otherwise paypal will reject it and get shitty. However it is a totally optional field

//prepare the call
        $payLoad["actionType"] = "PAY";
        $payLoad["cancelUrl"] = "http://localhost/ecommerce"; //this is required even though it isnt used
        $payLoad["returnUrl"] = "http://localhost/ecommerce"; //this is required even though it isnt used
        $payLoad["currencyCode"] = "INR";
        $payLoad["receiverList"] = $receiverList;
        $payLoad["feesPayer"] = "EACHRECEIVER"; //this could be SENDER or EACHRECEIVER
        //$payLoad["fundingConstraint"]=array("allowedFundingType"=>array("fundingTypeInfo"=>array("fundingType"=>"BALANCE")));//defaults to ECHECK but this takes ages and ages, so better to reject the payments if there isnt enough money in the account and then do a manual pull of bank funds through; more importantly, echecks have to be accepted/rejected by the user and i THINK balance doesnt
        $payLoad["sender"]["email"] = $ppemail; //the paypal email address of the where the money is coming from

//run the call
        $API_Endpoint = "https://svcs$ppapicall.paypal.com/AdaptivePayments/Pay";
        $payLoad["requestEnvelope"] = array("errorLanguage" => urlencode("en_US"), "detailLevel" => urlencode("ReturnAll")); //add some debugging info the payLoad and setup the requestEnvelope
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-PAYPAL-REQUEST-DATA-FORMAT: JSON',
            'X-PAYPAL-RESPONSE-DATA-FORMAT: JSON',
            'X-PAYPAL-SECURITY-USERID: ' . $ppuserid,
            'X-PAYPAL-SECURITY-PASSWORD: ' . $pppass,
            'X-PAYPAL-SECURITY-SIGNATURE: ' . $ppsig,
            'X-PAYPAL-APPLICATION-ID: ' . $ppappid,
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payLoad)); //
        $response = curl_exec($ch);
        $response = json_decode($response, 1);

//analyse the output
        $payKey = $response["payKey"];
        $paymentExecStatus = $response["paymentExecStatus"];
        $correlationId = $response["responseEnvelope"]["correlationId"];
        $paymentInfoList = isset($response["paymentInfoList"]) ? $response["paymentInfoList"] : null;

        if ($paymentExecStatus != "ERROR") {

            foreach ($paymentInfoList["paymentInfo"] as $paymentInfo) {
//they will only be in this array if they had a paypal account
                $receiverEmail = $paymentInfo["receiver"]["email"];
                $receiverAmount = $paymentInfo["receiver"]["amount"];
                $withdrawalID = $paymentInfo["receiver"]["invoiceId"];
                $transactionId = $paymentInfo["transactionId"]; //what shows in their paypal account
                $senderTransactionId = $paymentInfo["senderTransactionId"]; //what shows in our paypal account
                $senderTransactionStatus = $paymentInfo["senderTransactionStatus"];
                $pendingReason = isset($paymentInfo["pendingReason"]) ? $paymentInfo["pendingReason"] : null;
            }

        } else {
//deal with it
        }
    }

}

<?php

namespace api\controllers;

use common\components\Common;
use common\models\AccountDetails;
use common\models\DeviceDetails;
use common\models\EmailFormat;
use common\models\UserAddresses;
use common\models\Users;
use Yii;

/* USE COMMON MODELS */
use yii\web\Controller;
use \yii\web\UploadedFile;

/**
 * MainController implements the CRUD actions for APIs.
 */
class UsersController extends \yii\base\Controller
{
    /*
     * Function : Login()
     * Description : The Restaurant's manager can login from application.
     * Request Params :Email address and password.
     * Response Params :
     * Author :Rutusha Joshi
     */

    /*
     * Function : Login()
     * Description : The Restaurant's manager can login from application.
     * Request Params :Email address and password.
     * Response Params :
     * Author :Rutusha Joshi
     */

    public function actionLogin()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('login_type');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }
        $requestParam = $amData['request_param'];
        if ($requestParam['login_type'] == "1") {
            $amRequiredParams = array('email', 'password', 'device_token', 'login_type', 'type');
            $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

            // If any getting error in request paramter then set error message.
            if (!empty($amParamsResult['error'])) {
                $amResponse = Common::errorResponse($amParamsResult['error']);
                Common::encodeResponseJSON($amResponse);
            }

            if (($model = Users::findOne(['email' => $requestParam['email'], 'password' => md5($requestParam['password'])])) !== null) {

                if (($modell = Users::findOne(['email' => $requestParam['email'], 'password' => md5($requestParam['password']), 'role_id' => [Yii::$app->params['userroles']['super_admin'], Yii::$app->params['userroles']['admin']]])) !== null) {
                    $ssMessage = ' You are not authorize to login.';
                    $amResponse = Common::errorResponse($ssMessage);
                } else if (($model1 = Users::findOne(['email' => $requestParam['email'], 'password' => md5($requestParam['password']), 'status' => "0"])) !== null) {
                    $ssMessage = ' User has been deactivated. Please contact admin.';
                    $amResponse = Common::errorResponse($ssMessage);
                } else if (($model2 = Users::findOne(['email' => $requestParam['email'], 'password' => md5($requestParam['password']), 'is_code_verified' => "0"])) !== null) {
                    $ssMessage = ' Your Email is not verified.Please check your inbox to verify email';
                    $amResponse = Common::errorResponse($ssMessage);
                } else {
                    if (($device_model = DeviceDetails::findOne(['type' => $requestParam['type'], 'user_id' => $model->id])) === null) {
                        $device_model = new DeviceDetails();
                    }

                    $device_model->setAttributes($amData['request_param']);
                    $device_model->device_token = $requestParam['device_token'];
                    $device_model->type = $requestParam['type'];
                    $device_model->user_id = $model->id;
                    //  $device_model->created_at    = date( 'Y-m-d H:i:s' );
                    $device_model->save(false);
                    $ssAuthToken = Common::generateToken($model->id);
                    $model->auth_token = $ssAuthToken;
                    $model->save(false);
                    $UserAddressDefault = UserAddresses::find()->where(['user_id' => $model->id, "is_default" => "1"])->one();
                    $AccountDetails = AccountDetails::find()->where(['user_id' => $model->id])->one();
                    $amReponseParam = [];
                    $ssMessage = 'successfully login.';
                    $amReponseParam['email'] = $model->email;
                    $amReponseParam['sell_active'] = !empty($AccountDetails) ? "true" : "false";
                    $amReponseParam['user_id'] = $model->id;
                    $amReponseParam['role_id'] = $model->role_id;
                    $amReponseParam['first_name'] = $model->first_name;
                    $amReponseParam['last_name'] = $model->last_name;
                    $amReponseParam['user_name'] = $model->user_name;
                    $amReponseParam['phone'] = !empty($model->phone) ? $model->phone : "";
                    $amReponseParam['city'] = !empty($model->city) ? $model->city : "";
                    $amReponseParam['pincode'] = !empty($model->pincode) ? $model->pincode : "";
                    $amReponseParam['auth_id'] = !empty($model->auth_id) ? $model->auth_id : "";
                    $parseUrl = parse_url($model->photo);
                    $amReponseParam['photo'] = !empty($model->photo) && file_exists(Yii::getAlias('@htmlpath') . '/' . $parseUrl['path']) ? $model->photo : Yii::$app->params['root_url'] . '/' . "uploads/dp/no_image.png";
                    $amReponseParam['device_token'] = $device_model->device_token;
                    $amReponseParam['type'] = $device_model->type;

                    $amReponseParam['defaultAddress'] = !empty($UserAddressDefault) ? $UserAddressDefault->address : "";
                    $amReponseParam['default_lat'] = !empty($UserAddressDefault) ? $UserAddressDefault->lat : "";
                    $amReponseParam['default_longg'] = !empty($UserAddressDefault) ? $UserAddressDefault->longg : "";
                    $amReponseParam['default_pincode'] = !empty($UserAddressDefault) ? $UserAddressDefault->pincode : "";
                    $amReponseParam['default_address_id'] = !empty($UserAddressDefault) ? $UserAddressDefault->id : "";

                    // $amReponseParam['gcm_registration_id'] = !empty($device_model->gcm_id) ? $device_model->gcm_id : "";
                    $amReponseParam['auth_token'] = $ssAuthToken;
                    $amReponseParam['login_type'] = $model->login_type;

                    $amResponse = Common::successResponse($ssMessage, array_map('strval', $amReponseParam));
                }
            } else {
                $ssMessage = 'Invalid email OR password.';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $amRequiredParams = array('email', 'device_token', 'login_type', 'user_name', 'first_name', 'last_name');
            $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

            // If any getting error in request paramter then set error message.
            if (!empty($amParamsResult['error'])) {
                $amResponse = Common::errorResponse($amParamsResult['error']);
                Common::encodeResponseJSON($amResponse);
            }
            if (($model = Users::findOne(['email' => $requestParam['email']])) !== null) {
                if ($model->login_type == $requestParam['login_type']) {
                    if (($modell = Users::findOne(['email' => $requestParam['email'], 'role_id' => [Yii::$app->params['userroles']['super_admin'], Yii::$app->params['userroles']['admin']]])) !== null) {
                        $ssMessage = ' You are not authorize to login.';
                        $amResponse = Common::errorResponse($ssMessage);
                    } else if (($model1 = Users::findOne(['email' => $requestParam['email'], 'status' => "0"])) !== null) {
                        $ssMessage = ' User has been deactivated. Please contact admin.';
                        $amResponse = Common::errorResponse($ssMessage);
                    } else {
                        if (($device_model = DeviceDetails::findOne(['type' => $requestParam['device_token'], 'user_id' => $model->id])) === null) {
                            $device_model = new DeviceDetails();
                        }

                        $device_model->setAttributes($amData['request_param']);
                        $device_model->device_token = $requestParam['device_token'];
                        $device_model->type = $requestParam['type'];
                        $device_model->user_id = $model->id;
                        //  $device_model->created_at    = date( 'Y-m-d H:i:s' );
                        $device_model->save(false);
                        $ssAuthToken = Common::generateToken($model->id);
                        $model->auth_token = $ssAuthToken;
                        $model->save(false);
                        $UserAddressDefault = UserAddresses::find()->where(['user_id' => $model->id, "is_default" => "1"])->one();
                        $amReponseParam['defaultAddress'] = !empty($UserAddressDefault) ? $UserAddressDefault->address : "";
                        $amReponseParam['default_lat'] = !empty($UserAddressDefault) ? $UserAddressDefault->lat : "";
                        $amReponseParam['default_longg'] = !empty($UserAddressDefault) ? $UserAddressDefault->longg : "";
                        $amReponseParam['default_pincode'] = !empty($UserAddressDefault) ? $UserAddressDefault->pincode : "";
                        $amReponseParam['default_address_id'] = !empty($UserAddressDefault) ? $UserAddressDefault->id : "";
                        $AccountDetails = AccountDetails::find()->where(['user_id' => $model->id])->one();
                        $ssMessage = 'successfully login.';
                        $amReponseParam['email'] = $model->email;
                        $amReponseParam['sell_active'] = !empty($AccountDetails) ? "true" : "false";
                        $amReponseParam['user_id'] = $model->id;
                        $amReponseParam['role_id'] = $model->role_id;
                        $amReponseParam['first_name'] = $model->first_name;
                        $amReponseParam['last_name'] = $model->last_name;
                        $amReponseParam['user_name'] = $model->user_name;
                        $amReponseParam['phone'] = !empty($model->phone) ? $model->phone : "";
                        $amReponseParam['city'] = !empty($model->city) ? $model->city : "";
                        $amReponseParam['pincode'] = !empty($model->pincode) ? $model->pincode : "";
                        $amReponseParam['auth_id'] = !empty($model->auth_id) ? $model->auth_id : "";
                        $amReponseParam['photo'] = !empty($model->photo) ? $model->photo : Yii::$app->params['root_url'] . '/' . "uploads/dp/no_image.png";
                        $amReponseParam['device_token'] = $device_model->device_token;
                        $amReponseParam['type'] = $device_model->type;
                        // $amReponseParam['gcm_registration_id'] = !empty($device_model->gcm_id) ? $device_model->gcm_id : "";
                        $amReponseParam['auth_token'] = $ssAuthToken;
                        $amReponseParam['login_type'] = $model->login_type;

                        $amResponse = Common::successResponse($ssMessage, array_map('strval', $amReponseParam));
                    }
                } else {
                    $model->login_type = $requestParam['login_type'];
                    $model->photo = !empty($requestParam['photo']) ? $requestParam['photo'] : "";
                    $model->role_id = Yii::$app->params['userroles']['user'];
                    $model->user_name = $requestParam['user_name'];
                    $model->city = !empty($requestParam['city']) ? $requestParam['city'] : "";
                    $ssAuthToken = Common::generateToken($model->id);
                    $model->auth_token = $ssAuthToken;
                    $model->auth_id = !empty($requestParam['auth_id']) ? $requestParam['auth_id'] : "";
                    $model->save(false);
                    if (($device_model = DeviceDetails::findOne(['type' => $requestParam['type'], 'user_id' => $model->id])) === null) {
                        $device_model = new DeviceDetails();
                    }
                    $device_model->setAttributes($amData['request_param']);
                    $device_model->device_token = $requestParam['device_token'];
                    $device_model->type = $requestParam['type'];
                    $device_model->user_id = $model->id;
                    //  $device_model->created_at    = date( 'Y-m-d H:i:s' );
                    $device_model->save(false);
                    $ssMessage = 'successfully login.';
                    $amReponseParam['email'] = $model->email;
                    $UserAddressDefault = UserAddresses::find()->where(['user_id' => $model->id, "is_default" => "1"])->one();
                    $amReponseParam['defaultAddress'] = !empty($UserAddressDefault) ? $UserAddressDefault->address : "";
                    $amReponseParam['default_lat'] = !empty($UserAddressDefault) ? $UserAddressDefault->lat : "";
                    $amReponseParam['default_longg'] = !empty($UserAddressDefault) ? $UserAddressDefault->longg : "";
                    $amReponseParam['default_pincode'] = !empty($UserAddressDefault) ? $UserAddressDefault->pincode : "";
                    $amReponseParam['default_address_id'] = !empty($UserAddressDefault) ? $UserAddressDefault->id : "";
                    $AccountDetails = AccountDetails::find()->where(['user_id' => $model->id])->one();
                    $amReponseParam['sell_active'] = !empty($AccountDetails) ? "true" : "false";
                    $amReponseParam['user_id'] = $model->id;
                    $amReponseParam['role_id'] = $model->role_id;
                    $amReponseParam['first_name'] = $model->first_name;
                    $amReponseParam['last_name'] = $model->last_name;
                    $amReponseParam['user_name'] = $model->user_name;
                    $amReponseParam['phone'] = !empty($model->phone) ? $model->phone : "";
                    $amReponseParam['city'] = !empty($model->city) ? $model->city : "";
                    $amReponseParam['pincode'] = !empty($model->pincode) ? $model->pincode : "";
                    $amReponseParam['auth_id'] = !empty($model->auth_id) ? $model->auth_id : "";
                    $amReponseParam['photo'] = !empty($model->photo) ? $model->photo : Yii::$app->params['root_url'] . '/' . "uploads/dp/no_image.png";
                    $amReponseParam['device_token'] = $device_model->device_token;
                    $amReponseParam['type'] = $device_model->type;
                    // $amReponseParam['gcm_registration_id'] = !empty($device_model->gcm_id) ? $device_model->gcm_id : "";
                    $amReponseParam['auth_token'] = $ssAuthToken;
                    $amReponseParam['login_type'] = $model->login_type;
                    $amResponse = Common::successResponse($ssMessage, array_map('strval', $amReponseParam));

                }
            } else {
                $model = new Users();
                $model->email = $requestParam['email'];
                $model->login_type = $requestParam['login_type'];
                $ssAuthToken = Common::generateToken($model->id);
                $model->auth_token = $ssAuthToken;
                $model->role_id = Yii::$app->params['userroles']['user'];
                $model->user_name = $requestParam['user_name'];
                $model->first_name = $requestParam['first_name'];
                $model->last_name = $requestParam['last_name'];
                $model->photo = !empty($requestParam['photo']) ? $requestParam['photo'] : "";
                $model->auth_id = !empty($requestParam['auth_id']) ? $requestParam['auth_id'] : "";
                $model->phone = !empty($requestParam['phone']) ? $requestParam['phone'] : "";
                $model->city = !empty($requestParam['city']) ? $requestParam['city'] : "";

                $model->is_code_verified = 1;
                $model->save(false);
                if (($device_model = DeviceDetails::findOne(['type' => $requestParam['type'], 'user_id' => $model->id])) === null) {
                    $device_model = new DeviceDetails();
                }
                $device_model->setAttributes($amData['request_param']);
                $device_model->device_token = $requestParam['device_token'];
                $device_model->type = $requestParam['type'];
                $device_model->user_id = $model->id;
                //  $device_model->created_at    = date( 'Y-m-d H:i:s' );
                $device_model->save(false);
                $ssMessage = 'successfully login.';
                $amReponseParam['email'] = $model->email;
                $AccountDetails = AccountDetails::find()->where(['user_id' => $model->id])->one();
                $amReponseParam['sell_active'] = !empty($AccountDetails) ? "true" : "false";
                $amReponseParam['user_id'] = $model->id;
                $amReponseParam['role_id'] = $model->role_id;
                $amReponseParam['first_name'] = $model->first_name;
                $amReponseParam['last_name'] = $model->last_name;
                $amReponseParam['user_name'] = $model->user_name;
                $amReponseParam['phone'] = !empty($model->phone) ? $model->phone : "";
                $amReponseParam['city'] = !empty($model->city) ? $model->city : "";
                $amReponseParam['pincode'] = !empty($model->pincode) ? $model->pincode : "";
                $amReponseParam['auth_id'] = !empty($model->auth_id) ? $model->auth_id : "";
                $amReponseParam['photo'] = !empty($model->photo) ? $model->photo : Yii::$app->params['root_url'] . '/' . "uploads/dp/no_image.png";
                $amReponseParam['device_token'] = $device_model->device_token;
                $amReponseParam['type'] = $device_model->type;
                $amReponseParam['defaultAddress'] = "";
                $amReponseParam['default_lat'] = "";
                $amReponseParam['default_longg'] = "";
                $amReponseParam['default_pincode'] = "";
                $amReponseParam['default_address_id'] = "";
                // $amReponseParam['gcm_registration_id'] = !empty($device_model->gcm_id) ? $device_model->gcm_id : "";
                $amReponseParam['auth_token'] = $ssAuthToken;
                $amReponseParam['login_type'] = $model->login_type;
                $amResponse = Common::successResponse($ssMessage, array_map('strval', $amReponseParam));
            }
        }

        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function : SignUp()
     * Description : new user singup.
     * Request Params : irst_name,last_name,email address,contact_no
     * Response Params : user_id,firstname,email,last_name, email,status
     * Author : Rutusha Joshi
     */

    public function actionSignUp()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_name', 'first_name', 'last_name', 'email', 'device_token', 'type');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        $requestParam = $amData['request_param'];
        $requestFileparam = $amData['file_param'];
        if (empty($requestParam['user_id'])) {
            if (!empty(Users::find()->where(["email" => $requestParam['email']])->one())) {
                $amResponse = Common::errorResponse("This Email id is already registered.");
                Common::encodeResponseJSON($amResponse);
            }
            if (!empty($requestParam['phone'])) {
                if (!empty(Users::find()->where(["phone" => $requestParam['phone']])->one())) {
                    $amResponse = Common::errorResponse("Phone you entered is already registered by other user.");
                    Common::encodeResponseJSON($amResponse);
                }
            }
            if (!empty(Users::find()->where(["user_name" => $requestParam['user_name']])->one())) {
                $amResponse = Common::errorResponse("This user name is not avalaible.Please try another user name");
                Common::encodeResponseJSON($amResponse);
            }
            $model = new Users();
            $model->login_type = 1;
            $model->password = !empty($requestParam['password']) ? md5($requestParam['password']) : "";
        } else {
            $snUserId = $requestParam['user_id'];
            $model = Users::findOne(["id" => $snUserId]);
            if (!empty($model)) {
                $ssEmail = $model->email;
                $modelUser = Users::find()->where("id != '" . $snUserId . "' AND email = '" . $requestParam['email'] . "'")->all();
                if (!empty($modelUser)) {
                    $amResponse = Common::errorResponse("Email you entered is already registred by other user.");
                    Common::encodeResponseJSON($amResponse);
                }
                if (!empty($requestParam['phone'])) {
                    $modelUserr = Users::find()->where("id != '" . $snUserId . "' AND phone = '" . $requestParam['phone'] . "'")->all();
                    if (!empty($modelUserr)) {
                        $amResponse = Common::errorResponse("Phone you entered is already registered by other user.");
                        Common::encodeResponseJSON($amResponse);
                    }
                }
                $modelUserr = Users::find()->where("id != '" . $snUserId . "' AND user_name = '" . $requestParam['user_name'] . "'")->all();
                if (!empty($modelUserr)) {
                    $amResponse = Common::errorResponse("This user name is not avalaible.Please try another user name");
                    Common::encodeResponseJSON($amResponse);
                }
            } else {
                $amResponse = Common::errorResponse("Invalid user_id");
                Common::encodeResponseJSON($amResponse);
            }
        }
        // Common::sendSms( $Textmessage, "$requestParam[phone]" );
        // Database field
        $model->user_name = $requestParam['user_name'];
        $model->first_name = $requestParam['first_name'];
        $model->last_name = $requestParam['last_name'];
        $model->email = $requestParam['email'];
        $amReponseParam['login_type'] = "$model->login_type";
        /* $model->address_line_1 = !empty($requestParam['address_line_1']) ? $requestParam['address_line_1'] : "";*/
        $model->phone = !empty($requestParam['phone']) ? Common::clean_special_characters($requestParam['phone']) : "";
        $model->city = !empty($requestParam['city']) ? $requestParam['city'] : "";
        $model->role_id = Yii::$app->params['userroles']['user'];
        $model->status = Yii::$app->params['user_status_value']['active'];
        $ssAuthToken = Common::generateToken($model->id);
        $model->auth_token = $ssAuthToken;
        $model->auth_id = !empty($requestParam['auth_id']) ? $requestParam['auth_id'] : "";
        $model->pincode = !empty($requestParam['pincode']) ? $requestParam['pincode'] : "";
        $model->generateAuthKey();
        Yii::$app->urlManager->createUrl(['site/email-verify', 'verify' => base64_encode($model->verification_code), 'e' => base64_encode($model->email)]);
        $email_verify_link = Yii::$app->params['root_url'] . '/site/email-verify?verify=' . base64_encode($model->verification_code) . '&e=' . base64_encode($model->email);
        if (isset($requestFileparam['photo']['name'])) {
            $model->photo = UploadedFile::getInstanceByName('photo');
            $Modifier = md5(($model->photo));
            $OriginalModifier = $Modifier . rand(11111, 99999);
            $Extension = $model->photo->extension;
            $model->photo->saveAs(__DIR__ . "../../../uploads/dp/" . $OriginalModifier . '.' . $model->photo->extension);
            $filename = $OriginalModifier . '.' . $Extension;
            $model->photo = Yii::$app->params['root_url'] . '/' . "uploads/dp/" . $filename;
        }
        if ($model->save(false)) {
            // Device Registration
            if (($device_model = Devicedetails::findOne([/*'gcm_id' => $amData['request_param']['gcm_registration_id'], */'user_id' => $model->id])) === null) {
                $device_model = new Devicedetails();
            }
            $device_model->setAttributes($amData['request_param']);
            $device_model->device_token = $requestParam['device_token'];
            $device_model->type = $requestParam['type'];
            //$device_model->gcm_id = !empty($requestParam['gcm_registration_id']) ? $requestParam['gcm_registration_id'] : "";
            $device_model->user_id = $model->id;
            $device_model->save(false);
            ///////////////////////////////////////////////////////////
            //Get email template from database for sign up WS
            ///////////////////////////////////////////////////////////
            if (empty($ssEmail)) {
                $ssEmail = $model->email;
            }
            if (empty($requestParam['user_id']) || ($ssEmail != $requestParam['email'])) {
                $emailformatemodel = EmailFormat::findOne(["title" => 'user_registration', "status" => '1']);
                if ($emailformatemodel) {

                    //create template file
                    $AreplaceString = array('{password}' => $requestParam['password'], '{username}' => $model->user_name, '{email}' => $model->email, '{email_verify_link}' => $email_verify_link);

                    $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);
                    $ssSubject = $emailformatemodel->subject;
                    //send email for new generated password
                    $ssResponse = Common::sendMail($model->email, Yii::$app->params['adminEmail'], $ssSubject, $body);
                }
            }

            $ssMessage = 'You are successfully registered.';
            $amReponseParam['email'] = $model->email;
            $AccountDetails = AccountDetails::find()->where(['user_id' => $model->id])->one();
            $UserAddressDefault = UserAddresses::find()->where(['user_id' => $model->id, "is_default" => "1"])->one();
            $amReponseParam['defaultAddress'] = !empty($UserAddressDefault) ? $UserAddressDefault->address : "";
            $amReponseParam['default_lat'] = !empty($UserAddressDefault) ? $UserAddressDefault->lat : "";
            $amReponseParam['default_longg'] = !empty($UserAddressDefault) ? $UserAddressDefault->longg : "";
            $amReponseParam['default_pincode'] = !empty($UserAddressDefault) ? $UserAddressDefault->pincode : "";
            $amReponseParam['default_address_id'] = !empty($UserAddressDefault) ? $UserAddressDefault->id : "";
            $amReponseParam['sell_active'] = !empty($AccountDetails) ? "true" : "false";
            $amReponseParam['user_id'] = "$model->id";
            $amReponseParam['role_id'] = $model->role_id;
            $amReponseParam['first_name'] = $model->first_name;
            $amReponseParam['last_name'] = $model->last_name;
            $amReponseParam['user_name'] = $model->user_name;
            $amReponseParam['phone'] = !empty($requestParam['phone']) ? $requestParam['phone'] : "";
            $amReponseParam['city'] = !empty($model->city) ? $model->city : "";
            $amReponseParam['pincode'] = !empty($model->pincode) ? $model->pincode : "";
            $amReponseParam['auth_id'] = !empty($model->auth_id) ? $model->auth_id : "";
            $parseUrl = parse_url($model->photo);
            $amReponseParam['photo'] = !empty($model->photo) && file_exists(Yii::getAlias('@htmlpath') . '/' . $parseUrl['path']) ? $model->photo : Yii::$app->params['root_url'] . '/' . "uploads/dp/no_image.png";
            $amReponseParam['device_token'] = $device_model->device_token;
            $amReponseParam['type'] = $device_model->type;
            //$amReponseParam['gcm_registration_id'] = !empty($device_model->gcm_id) ? $device_model->gcm_id : "";
            $amReponseParam['auth_token'] = $ssAuthToken;

            $amResponse = Common::successResponse($ssMessage, $amReponseParam);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function : verifyEmail()
     * Description : email verification
     * Request Params : verification_code,user_id
     * Author : Rutusha Joshi
     */

    public function actionVerifyCode()
    {
        $amResponse = $amResponseData = [];
        //Get all request parameter
        $amData = Common::checkRequestType();

        // Check required validation for request parameter.
        $amRequiredParams = array('verification_code', 'user_id');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        $requestParam = $amData['request_param'];
        $snUserId = $requestParam['user_id'];
        $ssCode = $requestParam['verification_code'];

        $modelUsers = Users::findOne(["id" => $snUserId, "verification_code" => $ssCode]);
        if (!empty($modelUsers)) {
            $modelUsers->is_code_verified = 1;
            $modelUsers->save(false);
            $amResponseData = [
                'is_mobile_verified' => '1',
            ];
            $amResponse = Common::successResponse("Code verified successfully.", $amResponseData);
        } else {
            $amResponseData = [
                'is_mobile_verified' => '0',
            ];
            $amResponse = Common::successResponse("Invalid verification code.", $amResponseData);
        }
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function : ResendVerificationCode()
     * Description : Re send verification code
     * Request Params : 'user_id', 'phone','country_code'
     * Author : Rutusha Joshi
     */

    public function actionResendVerificationCode()
    {
        $amResponse = $amResponseData = [];
        //Get all request parameter
        $amData = Common::checkRequestType();

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'phone');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        $requestParam = $amData['request_param'];
        $snUserId = $requestParam['user_id'];
        $ssPhone = $requestParam['phone'];

        $modelUsers = Users::findOne(["id" => $snUserId]);
        if (!empty($modelUsers)) {
            $SnRandomNumber = rand(1111, 9999);
            $Textmessage = "Your verification code is : " . $SnRandomNumber;
            // Common::sendSms( $Textmessage, "$requestParam[phone]" );
            $modelUsers->verification_code = $SnRandomNumber;
            $modelUsers->save(false);
            $amResponseData['Verification_code'] = $modelUsers->verification_code;
            $amResponse = Common::successResponse("Code sent successfully.", $amResponseData);
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function : ChangePassword()
     * Description : user can change password
     * Request Params : user_id,old_password, new_password
     * Response Params : success or error message
     * Author : Rutusha Joshi
     */

    public function actionChangePassword()
    {

        $amData = Common::checkRequestType();

        $amResponse = array();
        $ssMessage = '';
        // Check required validation for request parameter.
        $amRequiredParams = array('old_password', 'new_password', 'user_id');

        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {

            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }
        $requestParam = $amData['request_param'];
        // Check User Status
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken, $requestParam['user_id']);

        if (($model = Users::findOne(['id' => $requestParam['user_id'], 'password' => md5($requestParam['old_password']), 'status' => '1'])) !== null) {
            if ($model->role_id == Yii::$app->params['userroles']['user']) {
                $model->password = md5($amData['request_param']['new_password']);
                if ($model->save()) {
                    $ssMessage = 'Your password has been changed successfully.';
                    $amReponseParam['user_id'] = $model->id;
                    $amReponseParam['user_email'] = $model->email;
                    $amResponse = Common::successResponse($ssMessage, array_map('strval', $amReponseParam));
                }
            } else {
                $ssMessage = 'You are not authorize to change password';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $ssMessage = 'Old Password is wrong';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function : ForgotPassword()
     * Description : if user can forgot passord so send password by mail.
     * Request Params : email,auth_token
     * Response Params : success or error message
     * Author : Rutusha Joshi
     */

    public function actionForgotPassword()
    {

        $amData = Common::checkRequestType();
        $amResponse = array();

        $ssMessage = '';
        // Check required validation for request parameter.
        $amRequiredParams = array('email');

        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        $requestParam = $amData['request_param'];

        // Check User Status

        if (($omUsers = Users::findOne(['email' => $requestParam['email'], 'status' => Yii::$app->params['user_status_value']['active']])) !== null) {

            if (!Users::isPasswordResetTokenValid($omUsers->password_reset_token)) {
                $token = Users::generatePasswordResetToken();
                $omUsers->password_reset_token = $token;
                if (!$omUsers->save(false)) {
                    return false;
                }
            }
            $resetLink = Yii::$app->params['root_url'] . "/site/reset-password?token=" . $omUsers->password_reset_token;

            $emailformatemodel = EmailFormat::findOne(["title" => 'reset_password', "status" => '1']);
            if ($emailformatemodel) {

                //create template file
                $AreplaceString = array('{resetLink}' => $resetLink, '{username}' => $omUsers->user_name);
                $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);

                //send email for new generated password
                $mail = Common::sendMailToUser($omUsers->email, Yii::$app->params['adminEmail'], $emailformatemodel->subject, $body);
            }
            if ($mail == 1) {
                $amReponseParam['email'] = $omUsers->email;
                $ssMessage = 'Email has been sent successfully please check your email. ';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $ssMessage = 'Email could not be sent successfully try again later.';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $ssMessage = 'Please enter valid email address which is provided during sign up.';
            $amResponse = Common::errorResponse($ssMessage);
        }

        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function : Logout()
     * Description : Log out
     * Request Params : user_id,auth_token
     * Response Params :
     * Author : Rutusha Joshi
     */

    // For Geting Daily data by date
    public function actionLogout()
    {
        $amData = Common::checkRequestType();
        $amResponse = array();
        $ssMessage = '';
        $amRequiredParams = array('user_id', 'device_id');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);
        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }
        $requestParam = $amData['request_param'];
        // Check User Status
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken, $requestParam['user_id']);

        $userModel = Users::findOne(['id' => $requestParam['user_id']]);
        if (!empty($userModel)) {
            if (($device_model = Devicedetails::findOne(['device_token' => $amData['request_param']['device_id'], 'user_id' => $requestParam['user_id']])) !== null) {
                $device_model->delete();
                $userModel->auth_token = "";
                $userModel->save(false);
                $ssMessage = 'Logout successfully';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam = '');
            } else {
                $ssMessage = 'Your deivce token is invalid.';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $ssMessage = 'Invalid user_id';
            $amResponse = Common::errorResponse($ssMessage);
        }
        Common::encodeResponseJSON($amResponse);
    }
    /*
     * Function : EditProfile()
     * Description : Edit User Profile
     * Request Params : university_id,first_name,last_name,email address,contact_no
     * Response Params : user_id,firstname,email,last_name, email,status,created_at
     * Author : Rutusha Joshi
     */

    public function actionEditProfile()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'first_name', 'last_name', 'email', 'address', 'contact_no');
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
        if (!empty($requestParam['user_id'])) {

            if (!empty(Users::find()->where("email = '" . $requestParam['email'] . "' AND id != '" . $requestParam['user_id'] . "'")->one())) {
                $amResponse = Common::errorResponse("This Email id is already registered.");
                Common::encodeResponseJSON($amResponse);
            }
            if (!empty(Users::find()->where("contact_no = '" . $requestParam['contact_no'] . "' AND id != '" . $requestParam['user_id'] . "'")->one())) {

                $amResponse = Common::errorResponse("Contact Number you entered is already registered by other user.");
                Common::encodeResponseJSON($amResponse);
            }

            $snUserId = $requestParam['user_id'];
            $model = Users::findOne(["id" => $snUserId]);
            if (!empty($model)) {

                // Database field
                $model->first_name = $requestParam['first_name'];
                $model->last_name = $requestParam['last_name'];
                $model->address = !empty($requestParam['address']) ? $requestParam['address'] : "";
                $model->email = !empty($requestParam['email']) ? $requestParam['email'] : "";
                $model->contact_no = !empty($requestParam['contact_no']) ? $requestParam['contact_no'] : '';

                if ($model->save(false)) {
                    $ssMessage = 'Your profile has been updated successfully.';

                    $amReponseParam['user_email'] = $model->email;
                    $amReponseParam['user_id'] = $model->id;
                    $amReponseParam['first_name'] = $model->first_name;
                    $amReponseParam['last_name'] = $model->last_name;
                    $amReponseParam['address'] = !empty($model->address) ? $model->address : "";
                    $amReponseParam['contact_no'] = !empty($model->contact_no) ? $model->contact_no : "";
                    $amReponseParam['auth_token'] = !empty($model->auth_token) ? $model->auth_token : "";
                    $amResponse = Common::successResponse($ssMessage, array_map('strval', $amReponseParam));
                }
            } else {
                $ssMessage = 'Invalid User.';
                $amResponse = Common::errorResponse($ssMessage);
            }
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }
    /*
     * Function : GetUserDetails()
     * Description : Get User Details
     * Request Params : user_id
     * Response Params : user's details
     * Author : Rutusha Joshi
     */

    public function actionGetUserDetails()
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
            // Device Registration
            $ssMessage = 'User Profile Details.';

            $amReponseParam['user_email'] = $model->email;
            $amReponseParam['user_id'] = $model->id;
            $amReponseParam['first_name'] = $model->first_name;
            $amReponseParam['last_name'] = $model->last_name;
            $amReponseParam['address'] = $model->address;
            $amReponseParam['contact_no'] = $model->contact_no;

            $amResponse = Common::successResponse($ssMessage, array_map('strval', $amReponseParam));
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function :
     * Description : Reset Badge Count
     * Request Params :'user_id','auth_token'
     * Response Params :
     * Author :Rutusha Joshi
     */
    public function actionResetBadgeCount()
    {

        $amData = Common::checkRequestType();

        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id');

        $amParamsResult = Common::checkRequiredParams($amData['request_param'], $amRequiredParams);

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
        $oModelUser = Users::findOne($requestParam['user_id']);
        if (!empty($oModelUser)) {

            $oModelUser->badge_count = 0;
            $oModelUser->save(false);
            $ssMessage = "Badge count updated successfully.";
            $amResponse = Common::successResponse($ssMessage);
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }
    /*
     * Function : AddAddresses()
     * Description : Add Addresses
     * Request Params : user_id
     * Response Params : user's details
     * Author : Rutusha Joshi
     */

    public function actionAddAddresses()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'address', 'pincode', 'is_default');
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
            $oldAddress = UserAddresses::find()->where(['user_id' => $snUserId, "is_default" => 1])->one();
            if (!empty($oldAddress)) {
                $oldAddress->is_default = 0;
                $oldAddress->save(false);
            }
            $addressModel = new UserAddresses();
            $addressModel->user_id = $requestParam['user_id'];
            $addressModel->address = $requestParam['address'];
            $addressModel->pincode = $requestParam['pincode'];
            $addressModel->lat = !empty($requestParam['lat']) ? $requestParam['lat'] : "";
            $addressModel->longg = !empty($requestParam['longg']) ? $requestParam['longg'] : "";
            $addressModel->is_default = 1;
            $addressModel->save(false);
            $UserAddresses = UserAddresses::find()->where(['user_id' => $requestParam['user_id']])->asArray()->all();
            $amReponseParam = [];
            if (!empty($UserAddresses)) {
                array_walk($UserAddresses, function ($arr) use (&$amResponseData) {
                    $ttt = $arr;
                    $ttt['lat'] = !empty($ttt['lat']) ? $ttt['lat'] : "";
                    $ttt['longg'] = !empty($ttt['longg']) ? $ttt['longg'] : "";
                    $amResponseData[] = $ttt;
                    return $amResponseData;
                });
                $amReponseParam = $amResponseData;
            }
            $ssMessage = "User Address added successfully.";
            $amResponse = Common::successResponse($ssMessage, $amReponseParam);
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionGetAddressList()
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
        $snUserAddressList = [];
        if (!empty($model)) {
            $snUserAddressList = UserAddresses::find()->where(['user_id' => $requestParam['user_id']])->asArray()->all();

            if (!empty($snUserAddressList)) {
                $amReponseParam = $snUserAddressList;
                $ssMessage = 'User Address List';
            } else {
                $ssMessage = 'User Addresses not found.';
            }
            $amResponse = Common::successResponse($ssMessage, $amReponseParam);
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionSetDefaultUserAddress()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'address_id');
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
        $snUserAddressList = [];
        if (!empty($model)) {
            $snUserAddress = UserAddresses::find()->where(['user_id' => $requestParam['user_id'], "id" => $requestParam['address_id']])->one();

            if (!empty($snUserAddress)) {
                $defaultAddress = UserAddresses::find()->where(['user_id' => $requestParam['user_id'], "is_default" => "1"])->one();

                if (!empty($defaultAddress)) {
                    $defaultAddress->is_default = "0";
                    $defaultAddress->save(false);
                }

                $snUserAddress->is_default = "1";
                $snUserAddress->save(false);
                $amReponseParam = $snUserAddressList;
                $ssMessage = 'Defualt Address set successfully.';
            } else {
                $ssMessage = 'User Address not found.';
            }
            $amResponse = Common::successResponse($ssMessage, $amReponseParam);
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionAddUserAccountDetails()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'paypal_email', 'stripe_bank_account_holder_name', 'stripe_bank_account_holder_type', 'stripe_bank_routing_number', 'stripe_bank_account_number');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }
        $requestParam = $amData['request_param'];
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken, $requestParam['user_id']);
        //Check User Status//
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        $snUserAddressList = [];
        if (!empty($model)) {
            $AccountDetails = AccountDetails::find()->where(["user_id" => $requestParam['user_id']])->one();
            if (!empty($AccountDetails)) {
                $ssMessage = 'Your account details are already added';
                $amResponse = Common::errorResponse($ssMessage);
                Common::encodeResponseJSON($amResponse);
            }
// Generate Stripe Bank account and connect account from the data
            \Stripe\Stripe::setApiKey("sk_test_ZBaRU0wL5z8YaEEPUhY3jzgF00tdHXg5cp");
            try {
                // first create bank token
                $bankToken = \Stripe\Token::create([
                    'bank_account' => [
                        'country' => 'US',
                        'currency' => 'usd',
                        'account_holder_name' => $requestParam['stripe_bank_account_holder_name'],
                        'account_holder_type' => $requestParam['stripe_bank_account_holder_type'],
                        'routing_number' => $requestParam['stripe_bank_routing_number'],
                        'account_number' => $requestParam['stripe_bank_account_number'],
                    ],
                ]);
                $account_holder_name = explode(" ", $requestParam['stripe_bank_account_holder_name']);
                $first_name = $account_holder_name[0];
                $last_name = $account_holder_name[1];
                // second create stripe account
                $stripeAccount = \Stripe\Account::create([
                    "type" => "custom",
                    "country" => "US",
                    "email" => !empty($model->email) ? $model->email : $requestParam['paypal_email'],
                    "business_type" => "individual",
                    "business_profile" => [
                        "url" => "http://www.zenocraft.com",
                    ],
                    "individual" => [
                        "first_name" => $first_name,
                        "last_name" => $last_name,
                    ],
                    "requested_capabilities" => ['transfers'],
                ]);
                // third link the bank account with the stripe account
                $bankAccount = \Stripe\Account::createExternalAccount(
                    $stripeAccount->id, ['external_account' => $bankToken->id]
                );
                // Fourth stripe account update for tos acceptance
                \Stripe\Account::update(
                    $stripeAccount->id, [
                        'tos_acceptance' => [
                            'date' => time(),
                            'ip' => $_SERVER['REMOTE_ADDR'], // Assumes you're not using a proxy
                        ],
                    ]
                );
                $response = ["bankToken" => $bankToken->id, "stripeAccount" => $stripeAccount->id, "bankAccount" => $bankAccount->id];
                $accountDetailModel = new AccountDetails();
                $accountDetailModel->user_id = $requestParam['user_id'];
                $accountDetailModel->stripe_bank_account_holder_name = $requestParam['stripe_bank_account_holder_name'];
                $accountDetailModel->stripe_bank_account_holder_type = $requestParam['stripe_bank_account_holder_type'];
                $accountDetailModel->stripe_bank_routing_number = $requestParam['stripe_bank_routing_number'];
                $accountDetailModel->stripe_bank_account_number = $requestParam['stripe_bank_account_number'];
                $accountDetailModel->stripe_bank_token = $response['bankToken'];
                $accountDetailModel->stripe_connect_account_id = $response['stripeAccount'];
                $accountDetailModel->stripe_bank_accout_id = $response['bankAccount'];
                $accountDetailModel->paypal_email = $requestParam['paypal_email'];
                $accountDetailModel->save(false);
                $amReponseParam = $accountDetailModel;
                $ssMessage = 'Stripe account detail successfully added.';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);

            } catch (\Exception $e) {
                p($e);
                $ssMessage = 'Something went wrong';
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

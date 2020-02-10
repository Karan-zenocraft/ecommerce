<?php

namespace api\controllers;

use common\components\Common;
use common\models\Categories;
use common\models\Products;
use common\models\Users;
use Yii;

/* USE COMMON MODELS */
use yii\web\Controller;
use \yii\web\UploadedFile;

/**
 * MainController implements the CRUD actions for APIs.
 */
class ProductsController extends \yii\base\Controller
{

    /*
     * Function : AddProduct()
     * Description : Add Product
     * Request Params : user_id
     * Response Params : user's details
     * Author : Rutusha Joshi
     */

    public function actionAddProduct()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'category_id', 'title', 'description', 'brand', 'year_of_purchase', 'location_address', 'lat', 'longg', 'price', 'is_rent', 'quantity', 'status', 'product_id');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }
        $requestParam = $amData['request_param'];
        $requestFileparam = $amData['file_param'];
        //Check User Status//
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken, $requestParam['user_id']);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if ($requestParam['is_rent'] == "1") {
            if (empty($requestParam['rent_price']) || empty($requestParam['rent_price_duration'])) {
                $ssMessage = "Please add rent_price and rent price duration keys.";
                $amResponse = Common::errorResponse($ssMessage);
                Common::encodeResponseJSON($amResponse);
            }
        }
        if (!empty($model)) {
            $category_check = Categories::findOne($requestParam['category_id']);
            if (!empty($category_check)) {
                if (!empty($requestParam['product_id'])) {
                    $productModel = Products::findOne($requestParam['product_id']);
                } else {
                    $productModel = new Products();
                }
                $productModel->category_id = $requestParam['category_id'];
                $productModel->seller_id = $requestParam['user_id'];
                $productModel->title = $requestParam['title'];
                $productModel->description = $requestParam['description'];
                $productModel->brand = $requestParam['brand'];
                $productModel->year_of_purchase = $requestParam['year_of_purchase'];
                $productModel->location_address = $requestParam['location_address'];
                $productModel->lat = $requestParam['lat'];
                $productModel->longg = $requestParam['longg'];
                $productModel->price = $requestParam['price'];
                $productModel->is_rent = $requestParam['is_rent'];
                $productModel->rent_price = $requestParam['rent_price'];
                $productModel->rent_price_duration = $requestParam['rent_price_duration'];
                $productModel->quantity = $requestParam['quantity'];
                $productModel->status = $requestParam['status'];
                if (isset($requestFileparam['photo']['name'])) {
                    $productModel->photo = UploadedFile::getInstanceByName('photo');
                    $Modifier = md5(($productModel->photo));
                    $OriginalModifier = $Modifier . rand(11111, 99999);
                    $Extension = $productModel->photo->extension;
                    $productModel->photo->saveAs(__DIR__ . "../../../uploads/products/" . $OriginalModifier . '.' . $productModel->photo->extension);
                    $filename = $OriginalModifier . '.' . $Extension;
                    $productModel->photo = Yii::$app->params['root_url'] . '/' . "uploads/products/" . $filename;
                } else {
                    $productModel->photo = !empty($requestParam['product_id']) ? $productModel->photo : Yii::$app->params['root_url'] . '/' . "uploads/products/noimg.jpg";
                }
                $productModel->save(false);
                $amReponseParam = $productModel;

                $ssMessage = 'Your Product added successfully.';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $ssMessage = 'Invalid category_id.Please add valid category_id';
                $amResponse = Common::errorResponse($ssMessage);
            }

        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function : GetProductsList()
     * Description : Get Product List
     * Request Params : user_id
     * Response Params : user's details
     * Author : Rutusha Joshi
     */

    public function actionGetProductsList()
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
            if (!empty($requestParam['category_id'])) {
                $products = Products::find()->where(["category_id" => $requestParam['category_id']])->asArray()->all();
            } else if (!empty($requestParam['lat']) && !empty($requestParam['longg'])) {
                $user_latitude = $requestParam['lat'];
                $user_longitude = $requestParam['longg'];
                $radius = 10;
                $products = Products::find()->where("(6371 * acos( cos(radians({$user_latitude}) ) * cos(radians( `lat`))*cos( radians( `longg` ) - radians({$user_longitude}) ) + sin( radians({$user_latitude}) ) * sin( radians( `lat`)))) < {$radius}  ")->asArray()->all();
            } else {
                $products = Products::find()->asArray()->all();
            }
            if (!empty($products)) {
                $amReponseParam = $products;
                $ssMessage = 'Products List';
                $amResponse = Common::successResponse($ssMessage, $products);
            } else {
                $amReponseParam = [];
                $ssMessage = 'Products not found.';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            }

        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }
}

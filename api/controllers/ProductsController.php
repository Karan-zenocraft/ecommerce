<?php

namespace api\controllers;

use common\components\Common;
use common\models\Categories;
use common\models\ProductPhotos;
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
        $amRequiredParams = array('user_id', 'category_id', 'subcategory_id', 'title', 'description', 'year_of_purchase', 'price', 'is_rent', 'quantity', 'lat', 'longg', 'location_address');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }
        $requestParam = $amData['request_param'];
        $requestFileparam = $amData['file_param'];
        // p($requestFileparam);
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
                $productModel->subcategory_id = $requestParam['subcategory_id'];
                $productModel->seller_id = $requestParam['user_id'];
                $productModel->title = $requestParam['title'];
                $productModel->description = $requestParam['description'];
                $productModel->brand = !empty($requestParam['brand']) ? $requestParam['brand'] : "";
                $productModel->year_of_purchase = $requestParam['year_of_purchase'];
                $productModel->lat = $requestParam['lat'];
                $productModel->longg = $requestParam['longg'];
                $productModel->location_address = $requestParam['location_address'];
                $productModel->city = $requestParam['city'];
                $productModel->price = $requestParam['price'];
                $productModel->is_rent = $requestParam['is_rent'];
                $productModel->rent_price = $requestParam['rent_price'];
                $productModel->rent_price_duration = $requestParam['rent_price_duration'];
                $productModel->quantity = $requestParam['quantity'];
                if ($productModel->save(false)) {
                    if (isset($requestFileparam['photo']) && isset($requestFileparam['photo']['name'])) {
                        //if()
                        /*$photos = ProductPhotos::find()->where(['product_id' => $requestParam['product_id']])->all();*/
                        foreach ($requestFileparam['photo']['name'] as $key => $name) {
                            $photoModel = new ProductPhotos();
                            $photoModel->image_name = UploadedFile::getInstanceByName("photo[$key]");
                            $photoModel->product_id = $productModel->id;

                            $Modifier = md5(($photoModel->image_name));
                            $OriginalModifier = $Modifier . rand(11111, 99999);
                            $Extension = $photoModel->image_name->extension;
                            $photoModel->image_name->saveAs(__DIR__ . "../../../uploads/products/" . $OriginalModifier . '.' . $photoModel->image_name->extension);
                            $filename = $OriginalModifier . '.' . $Extension;
                            $photoModel->image_name = $filename;
                            $photoModel->image_path = Yii::$app->params['root_url'] . '/' . "uploads/products/" . $filename;
                            $photoModel->save(false);
                            $ProductPhotos[] = $photoModel;
                        }
                    }
                }
                $amReponseParam['product'] = $productModel;
                $amReponseParam['photos'] = $ProductPhotos;

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
            if (!empty($requestParam['lat']) && !empty($requestParam['longg'])) {
                $user_latitude = $requestParam['lat'];
                $user_longitude = $requestParam['longg'];
                $radius = 30;
                $query = "select products.*,user_adresses.*
                            from products
                            LEFT JOIN user_adresses ON products.address_id = user_adresses.id
                            WHERE round(( 3959 * acos( least(1.0,cos( radians(" . $user_latitude . ") ) * cos( radians(user_adresses.lat) ) * cos( radians(user_adresses.longg) - radians(" . $user_longitude . ") ) + sin( radians(" . $user_latitude . ") ) * sin( radians(user_adresses.lat))))), 1) < " . $radius . " AND is_approve = " . Yii::$app->params['is_approve_value']['true'] . "";
                $products = Yii::$app->db->createCommand($query)->queryAll();
                p($products);
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

<?php

namespace api\controllers;

use common\components\Common;
use common\models\Category;
use common\models\ProductPhotos;
use common\models\Products;
use common\models\Users;
use common\models\Wishlist;
/* USE COMMON MODELS */
use Yii;
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
        $amRequiredParams = array('user_id', 'category_id', 'subcategory_id', 'title', 'description', 'year_of_purchase', 'price', 'is_rent', 'quantity', 'lat', 'longg', 'location_address', 'discount');
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
            $category_check = Category::findOne($requestParam['category_id']);
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
                $productModel->brand_id = !empty($requestParam['brand_id']) ? $requestParam['brand_id'] : "";
                $productModel->year_of_purchase = $requestParam['year_of_purchase'];
                $productModel->lat = $requestParam['lat'];
                $productModel->longg = $requestParam['longg'];
                $productModel->location_address = $requestParam['location_address'];
                $productModel->city = !empty($requestParam['city']) ? $requestParam['city'] : "";
                $productModel->price = $requestParam['price'];
                $productModel->discount = $requestParam['discount'];
                $productModel->is_rent = $requestParam['is_rent'];
                $productModel->rent_price = $requestParam['rent_price'];
                $productModel->rent_price_duration = $requestParam['rent_price_duration'];
                $productModel->quantity = $requestParam['quantity'];
                $productModel->quantity_in_stock = $requestParam['quantity'];
                if ($productModel->save(false)) {
                    if (isset($requestFileparam['photo']) && isset($requestFileparam['photo']['name'])) {
                        if (!empty($requestParam['product_id'])) {
                            $photos = ProductPhotos::deleteAll(['product_id' => $requestParam['product_id']]);
                        }

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
                if (isset($requestFileparam['photo']) && isset($requestFileparam['photo']['name'])) {
                    $amReponseParam['photos'] = $ProductPhotos;
                }
                if (!empty($requestParam['product_id'])) {
                    $photos = ProductPhotos::find()->where(['product_id' => $requestParam['product_id']])->asArray()->all();
                    $amReponseParam['photos'] = $photos;
                }

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
            $query = "select *
                            from products WHERE is_approve = '" . Yii::$app->params['is_approve_value']['true'] . "' AND quantity >= '1' AND is_delete = '0'";
            if (!empty($requestParam['lat']) && !empty($requestParam['longg'])) {
                $user_latitude = $requestParam['lat'];
                $user_longitude = $requestParam['longg'];
                $radius = 30;
                $query = $query . " AND round(( 3959 * acos( least(1.0,cos( radians(" . $user_latitude . ") ) * cos( radians(lat) ) * cos( radians(longg) - radians(" . $user_longitude . ") ) + sin( radians(" . $user_latitude . ") ) * sin( radians(lat))))), 1) < " . $radius . "";
            }
            if (!empty($requestParam['category_id'])) {
                $query = $query . " AND category_id = '" . $requestParam['category_id'] . "'";
            }
            if (!empty($requestParam['price'])) {
                $query = $query . " AND price = '" . $requestParam['price'] . "'";
            }
            if (!empty($requestParam['brand_id'])) {
                $query = $query . " AND brand_id = '" . $requestParam['brand_id'] . "'";
            }
            if (!empty($requestParam['year_of_purchase'])) {
                $query = $query . " AND year_of_purchase = '" . $requestParam['year_of_purchase'] . "'";
            }
            if (!empty($requestParam['is_rent']) && ($requestParam['is_rent'] == "3")) {
                $query = $query;
            }
            if (isset($requestParam['is_rent']) && ($requestParam['is_rent'] != "3")) {
                $query = $query . " AND is_rent = '" . $requestParam['is_rent'] . "'";
            }
            $products = Yii::$app->db->createCommand($query)->queryAll();
            if (!empty($products)) {
                $wishlist = Wishlist::find()->where(['user_id' => $requestParam['user_id']])->asArray()->all();
                $wishlist_arr = array_column($wishlist, 'product_id');
                foreach ($products as $key => $product) {
                    $productPhotos = ProductPhotos::find()->where(['product_id' => $product['id']])->asArray()->all();
                    $product['is_wishlist'] = in_array($product['id'], $wishlist_arr) ? "true" : "false";
                    $product['rent_price'] = !empty($product['rent_price']) ? $product['rent_price'] : "";
                    $product['inventory_product_id'] = !empty($product['inventory_product_id']) ? $product['inventory_product_id'] : "";
                    $product['rent_price_duration'] = !empty($product['rent_price_duration']) ? $product['rent_price_duration'] : "";
                    $product['lat'] = !empty($product['lat']) ? $product['lat'] : "";
                    $product['longg'] = !empty($product['longg']) ? $product['longg'] : "";
                    $product['owner_discount'] = !empty($product['owner_discount']) ? $product['owner_discount'] : "0";
                    $product['productPhotos'] = !empty($productPhotos) ? $productPhotos : [];
                    $products[$key] = $product;
                }
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
    /*
     * Function : GetProductDetails()
     * Description : Get Product Details
     * Request Params : user_id
     * Response Params : user's details
     * Author : Rutusha Joshi
     */
    public function actionGetProductDetails()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'product_id');
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
            $product = Products::find()->with(['category' => function ($q) {
                return $q->select('id,title');
            }])->with(['subcategory' => function ($q) {
                return $q->select('id,title');
            }])->with('brand')->with('productPhotos')->with('seller')->where(["id" => $requestParam['product_id']])->asArray()->all();
            if (!empty($product)) {
                $wishlist = Wishlist::find()->where(['user_id' => $requestParam['user_id']])->asArray()->all();
                $wishlist_arr = array_column($wishlist, 'product_id');
                $product[0]['is_wishlist'] = in_array($requestParam['product_id'], $wishlist_arr) ? "true" : "false";
                $product[0]['seller_first_name'] = $product[0]['seller']['first_name'];
                $product[0]['seller_last_name'] = $product[0]['seller']['last_name'];
                $product[0]['owner_discount'] = !empty($product[0]['owner_discount']) ? $product[0]['owner_discount'] : "0";
                $product[0]['seller_email'] = !empty($product[0]['seller']['email']) ? $product[0]['seller']['email'] : "";
                $product[0]['seller_photo'] = !empty($product[0]['seller']['photo']) ? $product[0]['seller']['photo'] : "";
                $product[0]['rent_price'] = !empty($product[0]['rent_price']) ? $product[0]['rent_price'] : "";
                $product[0]['inventory_product_id'] = !empty($product[0]['inventory_product_id']) ? $product[0]['inventory_product_id'] : "";
                $product[0]['rent_price_duration'] = !empty($product[0]['rent_price_duration']) ? $product[0]['rent_price_duration'] : "";
                $product[0]['lat'] = !empty($product[0]['lat']) ? $product[0]['lat'] : "";
                $product[0]['longg'] = !empty($product[0]['longg']) ? $product[0]['longg'] : "";
                $product[0]['productPhotos'] = !empty($product[0]['productPhotos']) ? $product[0]['productPhotos'] : [];
                unset($product[0]['seller']);
                $amReponseParam = $product[0];
                $ssMessage = "Product's details";
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
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

    /*
     * Function : GetMyProductsList()
     * Description : Get My Product List
     * Request Params : user_id
     * Response Params : user's details
     * Author : Rutusha Joshi
     */

    public function actionGetMyProductsList()
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
            $products = Products::find()->with(['category' => function ($q) {
                return $q->select('id,title');
            }])->with(['subcategory' => function ($q) {
                return $q->select('id,title');
            }])->where(['seller_id' => $requestParam['user_id']])->asArray()->all();

            if (!empty($products)) {
                foreach ($products as $key => $product) {
                    $productPhotos = ProductPhotos::find()->where(['product_id' => $product['id']])->asArray()->all();
                    $product['rent_price'] = !empty($product['rent_price']) ? $product['rent_price'] : "";
                    $product['inventory_product_id'] = !empty($product['inventory_product_id']) ? $product['inventory_product_id'] : "";
                    $product['rent_price_duration'] = !empty($product['rent_price_duration']) ? $product['rent_price_duration'] : "";
                    $product['lat'] = !empty($product['lat']) ? $product['lat'] : "";
                    $product['longg'] = !empty($product['longg']) ? $product['longg'] : "";
                    $product['owner_discount'] = !empty($product['owner_discount']) ? $product['owner_discount'] : "0";
                    $product['productPhotos'] = !empty($productPhotos) ? $productPhotos : [];
                    $products[$key] = $product;
                }
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

    /*
     * Function : DeleteMyProduct()
     * Description : Delete My Product
     * Request Params : user_id,product_id
     * Response Params : Product detail
     * Author : Rutusha Joshi
     */

    public function actionDeleteMyProduct()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'product_id');
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
            $product = Products::find()->where(['seller_id' => $requestParam['user_id'], 'id' => $requestParam['product_id']])->one();

            if (!empty($product)) {
                $product->is_delete = "1";
                $product->save(false);
                $amReponseParam = [];
                $ssMessage = 'Product deleted Successfully.';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $ssMessage = 'Please provide valid product_id';
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

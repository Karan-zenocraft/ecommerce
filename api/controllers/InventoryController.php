<?php

namespace api\controllers;

use common\components\Common;
use common\models\Categories;
use common\models\ProductPhotos;
use common\models\Products;
use common\models\Users;
use common\models\Wishlist;
use Yii;
/* USE COMMON MODELS */
use yii\web\Controller;
use \yii\web\UploadedFile;
use common\models\Category;
use common\models\InventoryProducts;
use common\models\InventoryProductsPhotos;

/**
 * MainController implements the CRUD actions for APIs.
 */
class InventoryController extends \yii\base\Controller
{

    /*
     * Function : AddProduct()
     * Description : Add Product
     * Request Params : user_id
     * Response Params : user's details
     * Author : Rutusha Joshi
     */

    public function actionAddProductToInventory()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'category_id','product_name','serial_no','note','purchase_date','current_value','replacement_value','purchased_from','is_warranty');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }
        $requestParam = $amData['request_param'];
        $requestFileparam = $amData['file_param'];
        if(empty($requestFileparam['photo']['name'][0])){
            $amResponse = Common::errorResponse("Please upload product's photos");
            Common::encodeResponseJSON($amResponse);
        }
        // p($requestFileparam);
        //Check User Status//
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken, $requestParam['user_id']);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            $category_check = Category::findOne($requestParam['category_id']);
            if (!empty($category_check)) {
                if (!empty($requestParam['inventory_product_id'])) {
                    $productModel = InventoryProducts::findOne($requestParam['inventory_product_id']);
                    $old_reciept_image = $productModel->receipt_image;
                } else {
                    $productModel = new InventoryProducts();
                }
                $productModel->category_id = $requestParam['category_id'];
                $productModel->user_id = $requestParam['user_id'];
                $productModel->product_name = $requestParam['product_name'];
                $productModel->serial_no = $requestParam['serial_no'];
                $productModel->note = $requestParam['note'];
                $productModel->purchase_date = $requestParam['purchase_date'];
                $productModel->current_value = $requestParam['current_value'];
                $productModel->replacement_value = $requestParam['replacement_value'];
                $productModel->purchased_from = $requestParam['purchased_from'];
              if($requestParam['is_warranty'] == "1"){
                if(empty($requestParam['warranty_start_date']) || empty($requestParam['warranty_end_date'])){
                    $ssMessage = 'warranty_start_date and warranty_end_date can not be blank';
                    $amResponse = Common::errorResponse($ssMessage);
                    Common::encodeResponseJSON($amResponse);
                }else{
                    $productModel->is_warranty = "1"; 
                    $productModel->warranty_start_date = $requestParam['warranty_start_date'];
                    $productModel->warranty_end_date = $requestParam['warranty_end_date'];
                }
              }else{
                    $productModel->is_warranty = "0"; 
                    $productModel->warranty_start_date = "";
                    $productModel->warranty_end_date = "";
              }
                if (isset($requestFileparam['receipt_image']['name']) && !empty($requestFileparam['receipt_image']['name'])) {
                    $productModel->receipt_image = UploadedFile::getInstanceByName('receipt_image');
                    $Modifier = md5(($productModel->receipt_image));
                    $OriginalModifier = $Modifier . rand(11111, 99999);
                    $Extension = $productModel->receipt_image->extension;
                    $productModel->receipt_image->saveAs(__DIR__ . "../../../uploads/inventory_products/receipt_images/" . $OriginalModifier . '.' . $productModel->receipt_image->extension);
                    $productModel->receipt_image = $OriginalModifier . '.' . $Extension;
                    if(!empty($requestParam['inventory_product_id'])){

                     unlink(Yii::getAlias('@root') . '/uploads/inventory_products/receipt_images/' . $old_reciept_image);
                    }
                }
                if ($productModel->save(false)) {
                    if (isset($requestFileparam['photo']) && isset($requestFileparam['photo']['name']) && !empty($requestFileparam['photo']['name'])) {
                        if (!empty($requestParam['inventory_product_id'])) {
                            $photosOld = InventoryProductsPhotos::find()->where(['inventory_product_id' => $requestParam['inventory_product_id']])->asArray()->all();
                            if(!empty($photosOld)){
                                foreach ($photosOld as $key => $oldPhoto) {
                                    if (!empty($oldPhoto['image_name']) && file_exists(Yii::getAlias('@root') . '/uploads/inventory_products/' . $oldPhoto['image_name'])) {
                                            unlink(Yii::getAlias('@root') . '/uploads/inventory_products/' . $oldPhoto['image_name']);
                                        }
                                }
                            }
                             $photos = InventoryProductsPhotos::deleteAll(['inventory_product_id' => $requestParam['inventory_product_id']]);
                        }

                        foreach ($requestFileparam['photo']['name'] as $key => $name) {
                            $photoModel = new InventoryProductsPhotos();
                            $photoModel->image_name = UploadedFile::getInstanceByName("photo[$key]");
                            $photoModel->inventory_product_id = $productModel->id;

                            $Modifier = md5(($photoModel->image_name));
                            $OriginalModifier = $Modifier . rand(11111, 99999);
                            $Extension = $photoModel->image_name->extension;
                            $photoModel->image_name->saveAs(__DIR__ . "../../../uploads/inventory_products/" . $OriginalModifier . '.' . $photoModel->image_name->extension);
                            $filename = $OriginalModifier . '.' . $Extension;
                            $photoModel->image_name = $filename;
                          //  $photoModel->image_path = Yii::$app->params['root_url'] . '/' . "uploads/inventory_products/" . $filename;
                            $photoModel->save(false);
                          $photoModel->image_name = Yii::$app->params['root_url'] . '/' . "uploads/inventory_products/" .  $photoModel->image_name;

                            $ProductPhotos[] = $photoModel;
                        }
                    }
                }
                $productModel->receipt_image =  Yii::$app->params['root_url'] . '/' . "uploads/inventory_products/receipt_images/" .  $productModel->receipt_image;
                $amReponseParam['product'] = $productModel;
                if (isset($requestFileparam['photo']) && isset($requestFileparam['photo']['name'])) {
                    $amReponseParam['photos'] = $ProductPhotos;
                }
                if (!empty($requestParam['inventory_product_id'])) {
                    $photos = InventoryProductsPhotos::find()->where(['inventory_product_id' => $requestParam['inventory_product_id']])->asArray()->all();
                    foreach ($photos as $key => $photo) {
                       $photo['image_name'] = Yii::$app->params['root_url'] . '/' . "uploads/inventory_products/" . $photo['image_name'];
                       $photosWithPath[] = $photo;
                    }
                    $amReponseParam['photos'] = $photosWithPath;
                }

                $ssMessage = 'Your Product added to Inventory successfully.';
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
                            from products WHERE is_approve = '" . Yii::$app->params['is_approve_value']['true'] . "' AND quantity >= '1'";
            if (!empty($requestParam['lat']) && !empty($requestParam['longg'])) {
                $user_latitude = $requestParam['lat'];
                $user_longitude = $requestParam['longg'];
                $radius = 30;
                $query = $query." AND round(( 3959 * acos( least(1.0,cos( radians(" . $user_latitude . ") ) * cos( radians(lat) ) * cos( radians(longg) - radians(" . $user_longitude . ") ) + sin( radians(" . $user_latitude . ") ) * sin( radians(lat))))), 1) < " . $radius ."";
            }
            if(!empty($requestParam['category_id'])){
                $query = $query." AND category_id = '" . $requestParam['category_id'] . "'";
            }
            if(!empty($requestParam['price'])){
                $query = $query." AND price = '" . $requestParam['price'] . "'";
            }
              if(!empty($requestParam['brand_id'])){
                $query = $query." AND brand_id = '" . $requestParam['brand_id'] . "'";
            }
             if(!empty($requestParam['year_of_purchase'])){
                $query = $query." AND year_of_purchase = '" . $requestParam['year_of_purchase'] . "'";
            }
            if(!empty($requestParam['is_rent']) && ($requestParam['is_rent'] == "3")){
                $query = $query;
            } 
            if(isset($requestParam['is_rent']) && ($requestParam['is_rent'] != "3") ){
                $query = $query." AND is_rent = '" . $requestParam['is_rent'] . "'";
            }
            $products = Yii::$app->db->createCommand($query)->queryAll();
            if (!empty($products)) {
                $wishlist = Wishlist::find()->where(['user_id' => $requestParam['user_id']])->asArray()->all();
                $wishlist_arr = array_column($wishlist, 'product_id');
                foreach ($products as $key => $product) {
                    $productPhotos = ProductPhotos::find()->where(['product_id' => $product['id']])->asArray()->all();
                    $product['is_wishlist'] = in_array($product['id'], $wishlist_arr) ? "true" : "false";
                    $product['rent_price'] = !empty($product['rent_price']) ? $product['rent_price'] : "";
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
            $product = Products::find()->with(['category'=>function($q){
                        return $q->select('id,title');
                    }])->with(['subcategory'=>function($q){
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
            $products = Products::find()->with(['category'=>function($q){
                        return $q->select('id,title');
                    }])->with(['subcategory'=>function($q){
                        return $q->select('id,title');
                    }])->where(['seller_id' => $requestParam['user_id']])->asArray()->all();

            if (!empty($products)) {
                foreach ($products as $key => $product) {
                    $productPhotos = ProductPhotos::find()->where(['product_id' => $product['id']])->asArray()->all();
                    $product['rent_price'] = !empty($product['rent_price']) ? $product['rent_price'] : "";
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
                $product->delete();
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

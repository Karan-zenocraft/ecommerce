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
use common\models\InventoryProductsReceiptImages;

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
   /*             if (isset($requestFileparam['receipt_image']['name']) && !empty($requestFileparam['receipt_image']['name'])) {
                    $productModel->receipt_image = UploadedFile::getInstanceByName('receipt_image');
                    $Modifier = md5(($productModel->receipt_image));
                    $OriginalModifier = $Modifier . rand(11111, 99999);
                    $Extension = $productModel->receipt_image->extension;
                    $productModel->receipt_image->saveAs(__DIR__ . "../../../uploads/receipt_images/" . $OriginalModifier . '.' . $productModel->receipt_image->extension);
                    $productModel->receipt_image = $OriginalModifier . '.' . $Extension;
                    if(!empty($requestParam['inventory_product_id'])){

                     unlink(Yii::getAlias('@root') . '/uploads/receipt_images/' . $old_reciept_image);
                    }
                }*/
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

                if (isset($requestFileparam['receipt_image']) && isset($requestFileparam['receipt_image']['name']) && !empty($requestFileparam['receipt_image']['name'])) {
                        if (!empty($requestParam['inventory_product_id'])) {
                            $reciptImageOld = InventoryProductsReceiptImages::find()->where(['inventory_product_id' => $requestParam['inventory_product_id']])->asArray()->all();
                            if(!empty($reciptImageOld)){
                                foreach ($reciptImageOld as $key => $oldecepitImage) {
                                    if (!empty($oldecepitImage['image_name']) && file_exists(Yii::getAlias('@root') . '/uploads/receipt_images/' . $oldecepitImage['image_name'])) {
                                            unlink(Yii::getAlias('@root') . '/uploads/receipt_images/' . $oldecepitImage['image_name']);
                                        }
                                }
                            }
                             $photos = InventoryProductsReceiptImages::deleteAll(['inventory_product_id' => $requestParam['inventory_product_id']]);
                        }

                        foreach ($requestFileparam['receipt_image']['name'] as $key => $name) {
                            $receiptImageModel = new InventoryProductsReceiptImages();
                            $receiptImageModel->image_name = UploadedFile::getInstanceByName("receipt_image[$key]");
                            $receiptImageModel->inventory_product_id = $productModel->id;

                            $Modifier = md5(($receiptImageModel->image_name));
                            $OriginalModifier = $Modifier . rand(11111, 99999);
                            $Extension = $receiptImageModel->image_name->extension;
                            $receiptImageModel->image_name->saveAs(__DIR__ . "../../../uploads/receipt_images/" . $OriginalModifier . '.' . $receiptImageModel->image_name->extension);
                            $filename = $OriginalModifier . '.' . $Extension;
                            $receiptImageModel->image_name = $filename;
                            $receiptImageModel->save(false);
                          $receiptImageModel->image_name = Yii::$app->params['root_url'] . '/' . "uploads/receipt_images/" .  $receiptImageModel->image_name;

                            $receiptImages[] = $receiptImageModel;
                        }
                    }
                }
                $amReponseParam['product'] = $productModel;
                if (isset($requestFileparam['photo']) && isset($requestFileparam['photo']['name']) && !empty($requestFileparam['photo']['name'])) {
                    $amReponseParam['photos'] = $ProductPhotos;
                }
                if (isset($requestFileparam['receipt_image']) && isset($requestFileparam['receipt_image']['name']) && !empty($requestFileparam['receipt_image']['name'])) {
                    $amReponseParam['receipt_images'] = $receiptImages;
                }
                if (!empty($requestParam['inventory_product_id'])) {
                    $photos = InventoryProductsPhotos::find()->where(['inventory_product_id' => $requestParam['inventory_product_id']])->asArray()->all();
                    foreach ($photos as $key => $photo) {
                       $photo['image_name'] = Yii::$app->params['root_url'] . '/' . "uploads/inventory_products/" . $photo['image_name'];
                       $photosWithPath[] = $photo;
                    }
                    $amReponseParam['photos'] = $photosWithPath;
                }

                 if (!empty($requestParam['inventory_product_id'])) {
                    $receipt_images = InventoryProductsReceiptImages::find()->where(['inventory_product_id' => $requestParam['inventory_product_id']])->asArray()->all();
                    foreach ($receipt_images as $key => $image) {
                       $image['image_name'] = Yii::$app->params['root_url'] . '/' . "uploads/receipt_images/" . $image['image_name'];
                       $imagesWithPath[] = $image;
                    }
                    $amReponseParam['receipt_images'] = $imagesWithPath;
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

    public function actionGetCategoryList()
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
            $categoriesList = Category::find()->asArray()->all();
            if (!empty($categoriesList)) {
                foreach ($categoriesList as $key => $category) {
                    $category['photo'] = !empty($category['photo']) ? $category['photo'] : "";
                    $category['parent_id'] = !empty($category['parent_id']) ? $category['parent_id'] : "";
                    $categories[] = $category;
                }
                $amReponseParam = $categories;
                $ssMessage = 'All Categories List';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $amReponseParam = [];
                $ssMessage = 'Categories not found.';
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
    public function actionGetMyInventoryProductDetails()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'inventory_product_id');
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
            $product = InventoryProducts::find()->with(['category'=>function($q){
                        return $q->select('id,title');
                    }])->with('inventoryProductsPhotos')->with('inventoryProductsReceiptImages')->with(['user'=>function($q){
                        return $q->select('id,first_name,last_name,email,user_name,phone,photo,city');
                    }])->where(["id" => $requestParam['inventory_product_id']])->asArray()->all();
            if (!empty($product)) {
                $inventoryProductsPhotos = $product[0]['inventoryProductsPhotos'];
                foreach ($inventoryProductsPhotos as $key => $photo) {
                   $photo['image_name'] = $photo['image_name'] = Yii::$app->params['root_url'] . '/' . "uploads/inventory_products/" . $photo['image_name'];
                   $photos[] = $photo;
                }
                $product[0]['inventoryProductsPhotos'] = $photos; 
                $inventoryProductsReceiptImages = $product[0]['inventoryProductsReceiptImages'];
                if(!empty($inventoryProductsReceiptImages)){
                    foreach ($inventoryProductsReceiptImages as $key => $image) {
                       $image['image_name'] = $image['image_name'] = Yii::$app->params['root_url'] . '/' . "uploads/receipt_images/" . $image['image_name'];
                       $images[] = $image;
                    }
                    $product[0]['inventoryProductsReceiptImages'] = $images; 

                }else{
                   $product[0]['inventoryProductsReceiptImages'] = [];  
                }
                $amReponseParam = $product[0];
                $ssMessage = "Inventory Product's details";
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $amReponseParam = [];
                $ssMessage = 'Inventory Product not found.';
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

    public function actionGetMyInventoryProductsList()
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
            $products = InventoryProducts::find()->with(['category'=>function($q){
                        return $q->select('id,title');
                    }])->with('inventoryProductsPhotos')->with('inventoryProductsReceiptImages')->where(['user_id' => $requestParam['user_id']])->asArray()->all();

            if (!empty($products)) {
                $replacement_value_arr = array_column($products,'replacement_value');
                foreach ($products as $key => $product) {
                    $inventoryProductsPhotos = $product['inventoryProductsPhotos'];
                    foreach ($inventoryProductsPhotos as $key => $photo) {
                       $photo['image_name'] = $photo['image_name'] = Yii::$app->params['root_url'] . '/' . "uploads/inventory_products/" . $photo['image_name'];
                       $photos[] = $photo;
                    }
                    $inventoryProductsReceiptImages = $product['inventoryProductsReceiptImages'];

                    if(!empty($inventoryProductsReceiptImages)){
                    foreach ($inventoryProductsReceiptImages as $key => $image) {
                       $image['image_name'] = $image['image_name'] = Yii::$app->params['root_url'] . '/' . "uploads/receipt_images/" . $image['image_name'];
                       $images[] = $image;
                    }
                    $product['inventoryProductsReceiptImages'] = $images; 

                }else{
                   $product['inventoryProductsReceiptImages'] = [];  
                }
                    $product['inventoryProductsPhotos']= $photos;
                    $productsWithPath[] = $product;
                }
                $amReponseParam['products'] = $productsWithPath;
                $amReponseParam['replacement_total_value'] = array_sum($replacement_value_arr);
                $ssMessage = 'Inventory Products List';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $amReponseParam['products'] = [];
                $amReponseParam['replacement_total_value'] = "";
                $ssMessage = 'Inventory Products not found.';
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

    public function actionDeleteInventoryProduct()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'inventory_product_id');
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
            $product = InventoryProducts::find()->where(['user_id' => $requestParam['user_id'], 'id' => $requestParam['inventory_product_id']])->one();

            if (!empty($product)) {
                $ProductPhotos = InventoryProductsPhotos::find()->where(["inventory_product_id"=>$requestParam['inventory_product_id']])->asArray()->all();
                $receipt_images = InventoryProductsReceiptImages::find()->where(["inventory_product_id"=>$requestParam['inventory_product_id']])->asArray()->all();
                $photos = !empty($ProductPhotos) ? array_column($ProductPhotos,'image_name') : "";
                $images = !empty($receipt_images) ? array_column($receipt_images,'image_name') : ""; 
                if($product->delete()){
                    if(!empty($photos)){ 
                        foreach ($photos as $key => $photo) {
                           if (!empty($photo) && file_exists(Yii::getAlias('@root') . '/uploads/inventory_products/' . $photo)) {
                                    unlink(Yii::getAlias('@root') . '/uploads/inventory_products/' . $photo);
                                        }
                        }
                    }
                      if(!empty($images)){ 
                         foreach ($images as $key => $image) {
                       if (!empty($image) && file_exists(Yii::getAlias('@root') . '/uploads/receipt_images/' . $image)) {
                                unlink(Yii::getAlias('@root') . '/uploads/receipt_images/' . $image);
                                    }
                    }
                }
                }
                $amReponseParam = [];
                $ssMessage = 'Product deleted Successfully from the Inventory.';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $ssMessage = 'Please provide valid inventory_product_id';
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

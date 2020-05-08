<?php

namespace common\models\base;

use Yii;
use common\models\Users;
use common\models\InventoryProductsPhotos;
use common\models\InventoryProductsQuery;
use common\models\Category; 
use common\models\InventoryProductsReceiptImages;



/**
 * This is the model class for table "inventory_products".
*
    * @property integer $id
    * @property integer $user_id
    * @property string $product_name
    * @property integer $category_id
    * @property string $serial_no
    * @property string $note
    * @property string $receipt_image
    * @property string $purchase_date
    * @property integer $current_value
    * @property integer $replacement_value
    * @property string $purchased_from
    * @property string $is_warranty
    * @property string $warranty_start_date
    * @property string $warranty_end_date
    * @property string $status
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Users $user
            * @property InventoryProductsPhotos[] $inventoryProductsPhotos
    */
class InventoryProductsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'inventory_products';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['user_id', 'product_name', 'category_id', 'serial_no', 'note', 'purchase_date', 'current_value', 'replacement_value', 'purchased_from', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'category_id', 'current_value', 'replacement_value'], 'integer'],
            [['purchase_date', 'warranty_start_date', 'warranty_end_date', 'created_at', 'updated_at'], 'safe'],
            [['is_warranty', 'status'], 'string'],
            [['product_name', 'serial_no', 'note', 'receipt_image', 'purchased_from'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'user_id' => 'User ID',
    'product_name' => 'Product Name',
    'category_id' => 'Category ID',
    'serial_no' => 'Serial No',
    'note' => 'Note',
    'receipt_image' => 'Receipt Image',
    'purchase_date' => 'Purchase Date',
    'current_value' => 'Current Value',
    'replacement_value' => 'Replacement Value',
    'purchased_from' => 'Purchased From',
    'is_warranty' => 'Is Warranty',
    'warranty_start_date' => 'Warranty Start Date',
    'warranty_end_date' => 'Warranty End Date',
    'status' => 'Status',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    public function getCategory() 
   { 
   return $this->hasOne(Category::className(), ['id' => 'category_id']); 
   } 

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUser()
    {
    return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getInventoryProductsPhotos()
    {
    return $this->hasMany(InventoryProductsPhotos::className(), ['inventory_product_id' => 'id']);
    }

     public function getInventoryProductsReceiptImages() 
       { 
        return $this->hasMany(InventoryProductsReceiptImages::className(), ['inventory_product_id' => 'id']); 
       } 

    /**
     * @inheritdoc
     * @return InventoryProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InventoryProductsQuery(get_called_class());
}
}
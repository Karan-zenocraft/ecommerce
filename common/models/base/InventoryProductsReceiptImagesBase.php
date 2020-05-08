<?php

namespace common\models\base;

use Yii;
use common\models\InventoryProducts;
use common\models\InventoryProductsReceiptImagesQuery;
/**
 * This is the model class for table "inventory_products_receipt_images".
*
    * @property integer $id
    * @property integer $inventory_product_id
    * @property string $image_name
    * @property string $created_at
    * @property string $updated_at
    *
            * @property InventoryProducts $inventoryProduct
    */
class InventoryProductsReceiptImagesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'inventory_products_receipt_images';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['inventory_product_id', 'image_name', 'created_at', 'updated_at'], 'required'],
            [['inventory_product_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['image_name'], 'string', 'max' => 255],
            [['inventory_product_id'], 'exist', 'skipOnError' => true, 'targetClass' => InventoryProducts::className(), 'targetAttribute' => ['inventory_product_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'inventory_product_id' => 'Inventory Product ID',
    'image_name' => 'Image Name',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getInventoryProduct()
    {
    return $this->hasOne(InventoryProducts::className(), ['id' => 'inventory_product_id']);
    }

    /**
     * @inheritdoc
     * @return InventoryProductsReceiptImagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InventoryProductsReceiptImagesQuery(get_called_class());
}
}
<?php

namespace common\models\base;

use Yii;
use common\models\InventoryProducts;
use common\models\InventoryProductsPhotosQuery;

/**
 * This is the model class for table "inventory_products_photos".
*
    * @property integer $id
    * @property integer $inventory_product_id
    * @property string $image_name
    * @property string $created_at
    * @property string $updated_at
    *
            * @property InventoryProducts $inventoryProduct
    */
class InventoryProductsPhotosBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'inventory_products_photos';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['id', 'inventory_product_id', 'image_name', 'created_at', 'updated_at'], 'required'],
            [['id', 'inventory_product_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['image_name'], 'string', 'max' => 255],
            [['id'], 'unique'],
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
     * @return InventoryProductsPhotosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InventoryProductsPhotosQuery(get_called_class());
}
}
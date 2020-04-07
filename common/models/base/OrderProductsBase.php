<?php

namespace common\models\base;

use common\models\Orders;
use common\models\Products;
use common\models\Users;
use Yii;

/**
 * This is the model class for table "order_products".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $quantity
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Orders $order
 * @property Products $product
 */
class OrderProductsBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'order_products';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'quantity', 'created_at', 'updated_at'], 'required'],
            [['order_id', 'product_id', 'quantity'], 'integer'],
            [['created_at', 'updated_at', 'discount', 'tax', 'actual_price', 'price_with_quantity'
                , 'discounted_price'
                , 'total_price_with_tax_discount', 'seller_id', 'seller_amount'], 'safe'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

/**
 * @inheritdoc
 */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'quantity' => 'Quantity',
            'discount' => 'Discount',
            'tax' => 'Tax',
            'price_with_quantity' => 'Price with Quantity',
            'discounted_price' => 'Discounted Price',
            'actual_price' => 'Actual Product Price',
            'total_price_with_tax_discount' => 'Total Price with tax and discount',
            'seller_id' => 'Seller',
            'seller_amount' => 'Seller Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }

    public function getSeller()
    {
        return $this->hasOne(Users::className(), ['id' => 'seller_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
}

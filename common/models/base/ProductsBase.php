<?php

namespace common\models\base;

use common\models\Categories;
use common\models\ProductPhotos;
use common\models\UserAdresses;
use common\models\Users;
use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $seller_id
 * @property string $title
 * @property string $description
 * @property string $brand
 * @property string $year_of_purchase
 * @property integer $address_id
 * @property integer $price
 * @property string $is_rent
 * @property integer $rent_price
 * @property integer $rent_price_duration
 * @property integer $quantity
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ProductPhotos[] $productPhotos
 * @property UserAdresses $address
 * @property Categories $category
 * @property Users $seller
 * @property UserAdresses $address0
 */
class ProductsBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'products';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['category_id', 'seller_id', 'title', 'description', 'address_id', 'price', 'is_rent', 'quantity', 'created_at', 'updated_at'], 'required'],
            [['category_id', 'seller_id', 'address_id', 'price', 'rent_price', 'rent_price_duration', 'quantity', 'status'], 'integer'],
            [['description', 'is_rent'], 'string'],
            [['year_of_purchase', 'created_at', 'updated_at'], 'safe'],
            [['title', 'brand'], 'string', 'max' => 255],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserAdresses::className(), 'targetAttribute' => ['address_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['seller_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['seller_id' => 'id']],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserAdresses::className(), 'targetAttribute' => ['address_id' => 'id']],
        ];
    }

/**
 * @inheritdoc
 */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'seller_id' => 'Seller ID',
            'title' => 'Title',
            'description' => 'Description',
            'brand' => 'Brand',
            'year_of_purchase' => 'Year Of Purchase',
            'address_id' => 'Address ID',
            'price' => 'Price',
            'is_rent' => 'Is Rent',
            'rent_price' => 'Rent Price',
            'rent_price_duration' => 'Rent Price Duration',
            'quantity' => 'Quantity',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPhotos()
    {
        return $this->hasMany(ProductPhotos::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(UserAdresses::className(), ['id' => 'address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeller()
    {
        return $this->hasOne(Users::className(), ['id' => 'seller_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress0()
    {
        return $this->hasOne(UserAdresses::className(), ['id' => 'address_id']);
    }

    /**
     * @inheritdoc
     * @return ProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductsQuery(get_called_class());
    }
}

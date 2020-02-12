<?php

namespace common\models\base;

use common\models\Categories;
use common\models\ProductPhotos;
use common\models\ProductsQuery;
use common\models\SubCategories;
use common\models\Users;
use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $subcategory_id
 * @property integer $seller_id
 * @property string $title
 * @property string $description
 * @property string $brand
 * @property string $year_of_purchase
 * @property double $lat
 * @property double $longg
 * @property string $location_address
 * @property string $city
 * @property integer $price
 * @property string $is_rent
 * @property integer $rent_price
 * @property integer $rent_price_duration
 * @property integer $quantity
 * @property integer $status
 * @property string $is_approve
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ProductPhotos[] $productPhotos
 * @property Categories $category
 * @property Users $seller
 * @property SubCategories $subcategory
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
            [['category_id', 'subcategory_id', 'seller_id', 'title', 'description', 'lat', 'longg', 'location_address', 'city', 'price', 'is_rent', 'quantity', 'created_at', 'updated_at'], 'required'],
            [['category_id', 'subcategory_id', 'seller_id', 'price', 'rent_price', 'rent_price_duration', 'quantity', 'status'], 'integer'],
            [['description', 'location_address', 'is_rent', 'is_approve'], 'string'],
            [['year_of_purchase', 'created_at', 'updated_at'], 'safe'],
            [['lat', 'longg'], 'number'],
            [['title', 'brand', 'city'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['seller_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['seller_id' => 'id']],
            [['subcategory_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubCategories::className(), 'targetAttribute' => ['subcategory_id' => 'id']],
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
            'subcategory_id' => 'Subcategory ID',
            'seller_id' => 'Seller ID',
            'title' => 'Title',
            'description' => 'Description',
            'brand' => 'Brand',
            'year_of_purchase' => 'Year Of Purchase',
            'lat' => 'Lat',
            'longg' => 'Longg',
            'location_address' => 'Location Address',
            'city' => 'City',
            'price' => 'Price',
            'is_rent' => 'Is Rent',
            'rent_price' => 'Rent Price',
            'rent_price_duration' => 'Rent Price Duration',
            'quantity' => 'Quantity',
            'status' => 'Status',
            'is_approve' => 'Is Approve',
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
    public function getSubcategory()
    {
        return $this->hasOne(SubCategories::className(), ['id' => 'subcategory_id']);
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
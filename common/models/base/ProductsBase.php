<?php

namespace common\models\base;

use common\models\Categories;
use common\models\ProductsQuery;
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
 * @property integer $year_of_purchase
 * @property string $location_address
 * @property double $lat
 * @property double $longg
 * @property integer $price
 * @property string $is_rent
 * @property integer $rent_price
 * @property integer $rent_price_duration
 * @property integer $quantity
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Categories $category
 * @property Users $seller
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
            [['category_id', 'seller_id', 'title', 'description', 'location_address', 'lat', 'longg', 'price', 'is_rent', 'rent_price', 'rent_price_duration', 'quantity', 'created_at', 'updated_at'], 'required'],
            [['category_id', 'seller_id', 'year_of_purchase', 'price', 'rent_price', 'rent_price_duration', 'quantity', 'status'], 'integer'],
            [['description', 'location_address', 'is_rent'], 'string'],
            [['lat', 'longg'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'brand'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['seller_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['seller_id' => 'id']],
        ];
    }

/**
 * @inheritdoc
 */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category',
            'seller_id' => 'Seller',
            'title' => 'Title',
            'description' => 'Description',
            'brand' => 'Brand',
            'year_of_purchase' => 'Year Of Purchase',
            'location_address' => 'Location Address',
            'lat' => 'Lattitude',
            'longg' => 'Longitude',
            'price' => 'Price in USD',
            'is_rent' => 'Is avaliable for Rent',
            'rent_price' => 'Rent Price',
            'rent_price_duration' => 'Rent Price Duration',
            'quantity' => 'Quantity in stock',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
     * @inheritdoc
     * @return ProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductsQuery(get_called_class());
    }
}

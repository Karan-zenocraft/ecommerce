<?php

namespace common\models\base;

use common\models\ProductPhotosQuery;
use common\models\Products;
use Yii;

/**
 * This is the model class for table "product_photos".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $image_name
 * @property string $image_path
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Products $product
 */
class ProductPhotosBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'product_photos';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['product_id', 'image_name', 'image_path', 'created_at', 'updated_at'], 'required'],
            [['product_id'], 'integer'],
            [['image_path'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['image_name'], 'string', 'max' => 255],
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
            'product_id' => 'Product ID',
            'image_name' => 'Image Name',
            'image_path' => 'Image Path',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }

    /**
     * @inheritdoc
     * @return ProductPhotosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductPhotosQuery(get_called_class());
    }
}

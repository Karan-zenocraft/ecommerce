<?php

namespace common\models\base;

use common\models\Brands;
use common\models\Category;
use common\models\CategoryQuery;
use common\models\Products;
use Yii;

/**
 * This is the model class for table "Category".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $parent_id
 * @property string $photo
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $parent
 * @property Category[] $categories
 * @property Brands[] $brands
 * @property Brands[] $brands0
 * @property Products[] $products
 * @property Products[] $products0
 */
class CategoryBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'Category';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['title', 'created_at', 'updated_at'], 'required'],
            [['description'], 'string'],
            [['parent_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'photo'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

/**
 * @inheritdoc
 */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'parent_id' => 'Parent ID',
            'photo' => 'Photo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrands()
    {
        return $this->hasMany(Brands::className(), ['sub_category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrands0()
    {
        return $this->hasMany(Brands::className(), ['parent_category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts0()
    {
        return $this->hasMany(Products::className(), ['subcategory_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
}

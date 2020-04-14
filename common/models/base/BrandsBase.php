<?php

namespace common\models\base;

use common\models\Category;
use Yii;

/**
 * This is the model class for table "brands".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $parent_category_id
 * @property integer $sub_category_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $subCategory
 * @property Category $parentCategory
 */
class BrandsBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'brands';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['title', 'parent_category_id', 'sub_category_id', 'created_at', 'updated_at'], 'required'],
            [['description'], 'string'],
            [['parent_category_id', 'sub_category_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['sub_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['sub_category_id' => 'id']],
            [['parent_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_category_id' => 'id']],
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
            'parent_category_id' => 'Parent Category',
            'sub_category_id' => 'Sub Category',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'sub_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_category_id']);
    }
}

<?php

namespace common\models\base;

use common\models\Categories;
use common\models\SubCategoriesQuery;
use Yii;

/**
 * This is the model class for table "sub_categories".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Categories $category
 */
class SubCategoriesBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'sub_categories';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['category_id', 'title', 'description', 'created_at', 'updated_at'], 'required'],
            [['category_id'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'title' => 'Title',
            'description' => 'Description',
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
     * @inheritdoc
     * @return SubCategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubCategoriesQuery(get_called_class());
    }
}

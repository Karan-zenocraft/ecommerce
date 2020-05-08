<?php

namespace common\models;

use yii\helpers\ArrayHelper;

class Category extends \common\models\base\CategoryBase
{
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->setAttribute('created_at', date('Y-m-d H:i:s'));
        }
        $this->setAttribute('updated_at', date('Y-m-d H:i:s'));

        return parent::beforeSave($insert);
    }
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['title', 'description'], 'filter', "filter" => "trim"],
            [['parent_id'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }
    public function CategoryDropdown($id = "")
    {
        if (!empty($id)) {
            return ArrayHelper::map(Category::find()->where("id != $id")->orderBy('title')->asArray()->all(), 'id', 'title');
        } else {
            return ArrayHelper::map(Category::find()->orderBy('title')->asArray()->all(), 'id', 'title');
        }
    }

    public function ParentCategoryDropdown()
    {
        return ArrayHelper::map(Category::find()->where("parent_id is NULL")->orderBy('title')->asArray()->all(), 'id', 'title');

    }
    public function SubCategoryDropdown($parent_id)
    {
        return ArrayHelper::map(Category::find()->where(["parent_id" => $parent_id])->orderBy('title')->asArray()->all(), 'id', 'title');
    }

     public function AllCategoryDropdown()
    {
        return ArrayHelper::map(Category::find()->orderBy('title')->asArray()->all(), 'id', 'title');
    }
}

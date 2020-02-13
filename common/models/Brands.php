<?php

namespace common\models;

class Brands extends \common\models\base\BrandsBase
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
            [['title', 'parent_category_id', 'sub_category_id'], 'required'],
            [['title', 'parent_category_id'], 'filter', 'filter' => 'trim'],
            [['description'], 'filter', 'filter' => 'trim'],
            [['description'], 'string'],
            [['parent_category_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['parent_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_category_id' => 'id']],
            [['sub_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['sub_category_id' => 'id']],
        ];
    }
}

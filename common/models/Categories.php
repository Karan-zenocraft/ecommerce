<?php

namespace common\models;

use yii\helpers\ArrayHelper;

class Categories extends \common\models\base\CategoriesBase
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
            [['title', 'description'], 'filter', 'filter' => 'trim'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }
    public function CategoryDropdown()
    {
        return ArrayHelper::map(Categories::find()->orderBy('title')->asArray()->all(), 'id', 'title');
    }
    public static function CategoriesDropDown()
    {
        //->where(['status'=>Yii::$app->params['department_active_status']])
        return ArrayHelper::map(Category::find()->orderBy('title')->asArray()->all(), 'id', 'title');
    }
}

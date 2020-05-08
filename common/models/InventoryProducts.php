<?php

namespace common\models;

class InventoryProducts extends \common\models\base\InventoryProductsBase
{
       public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->setAttribute('created_at', date('Y-m-d H:i:s'));
        }
        $this->setAttribute('updated_at', date('Y-m-d H:i:s'));

        return parent::beforeSave($insert);
    }

    public function getInventoryProductCount($user_id){

    	$count = InventoryProducts::find()->where(['user_id'=>$user_id])->count();
    	return $count;
    }
     public function getInventoryProductReplacementValue($user_id){

    	$count = InventoryProducts::find()->select("SUM('replacement_value')")->where(['user_id'=>$user_id])->groupBy('user_id');
    	return $count;
    }
}
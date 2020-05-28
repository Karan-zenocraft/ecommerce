<?php

namespace common\models;

class Advertise extends \common\models\base\AdvertiseBase
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
            // [['image'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['url'], 'string', 'max' => 255],
            [['image'], 'image', 'extensions' => 'jpg, jpeg, gif, png'],

        ];
    }
}

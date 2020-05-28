<?php

namespace common\models\base;

use common\models\AdvertiseQuery;
use Yii;

/**
 * This is the model class for table "advertise".
 *
 * @property integer $id
 * @property string $image
 * @property string $url
 * @property string $created_at
 * @property string $updated_at
 */
class AdvertiseBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'advertise';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['image', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['image', 'url'], 'string', 'max' => 255],
        ];
    }

/**
 * @inheritdoc
 */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'url' => 'URL',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return AdvertiseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdvertiseQuery(get_called_class());
    }
}

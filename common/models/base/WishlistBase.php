<?php

namespace common\models\base;

use common\models\Products;
use common\models\Users;
use common\models\WishlistQuery;
use Yii;

/**
 * This is the model class for table "wish_list".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $product_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Products $product
 * @property Users $user
 */
class WishlistBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'wish_list';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['user_id', 'product_id', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'product_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

/**
 * @inheritdoc
 */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return WishlistQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WishlistQuery(get_called_class());
    }
}

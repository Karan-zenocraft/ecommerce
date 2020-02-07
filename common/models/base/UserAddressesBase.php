<?php

namespace common\models\base;

use common\models\UserAddressesQuery;
use common\models\Users;
use Yii;

/**
 * This is the model class for table "user_adresses".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $address
 * @property integer $pincode
 * @property string $is_default
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $user
 */
class UserAddressesBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'user_adresses';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['user_id', 'address', 'pincode', 'is_default', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'pincode'], 'integer'],
            [['address', 'is_default'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
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
            'address' => 'Address',
            'pincode' => 'Pincode',
            'is_default' => 'Is Default',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
     * @return UserAddressesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserAddressesQuery(get_called_class());
    }
}

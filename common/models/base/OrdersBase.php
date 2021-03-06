<?php

namespace common\models\base;

use common\models\OrderPayment;
use common\models\OrderProducts;
use common\models\UserAddresses;
use common\models\Users;
use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $buyer_id
 * @property string $payment_type
 * @property integer $discount
 * @property double $total_amount_paid
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property OrderProducts[] $orderProducts
 * @property Users $buyer
 */
class OrdersBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'orders';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['buyer_id', 'payment_type', 'created_at', 'updated_at'], 'required'],
            [['buyer_id', 'status'], 'integer'],
            [['payment_type'], 'string'],
            [['total_amount_paid'], 'number'],
            [['created_at', 'updated_at', 'user_address_id','seller_payment_status'], 'safe'],
            [['buyer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['buyer_id' => 'id']],
        ];
    }

/**
 * @inheritdoc
 */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'buyer_id' => 'Buyer',
            'payment_type' => 'Payment Type',
            'total_amount_paid' => 'Total Amount Paid',
            'user_address_id' => 'User Address',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProducts::className(), ['order_id' => 'id']);
    }
    public function getOrderPayment()
    {
        return $this->hasOne(OrderPayment::className(), ['order_id' => 'id']);
    }
    public function getUserAddress()
    {
        return $this->hasOne(UserAddresses::className(), ['id' => 'user_address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyer()
    {
        return $this->hasOne(Users::className(), ['id' => 'buyer_id']);
    }
}

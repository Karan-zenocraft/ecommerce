<?php

namespace common\models\base;

use common\models\OrderPaymentQuery;
use common\models\Orders;
use Yii;

/**
 * This is the model class for table "order_payment".
 *
 * @property integer $id
 * @property integer $order_id
 * @property string $transaction_id
 * @property string $created_at
 * @property string $updated_at
 */
class OrderPaymentBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'order_payment';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['order_id', 'transaction_id', 'created_at', 'updated_at'], 'required'],
            [['order_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['transaction_id'], 'string', 'max' => 255],
        ];
    }

/**
 * @inheritdoc
 */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'transaction_id' => 'Transaction ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return OrderPaymentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderPaymentQuery(get_called_class());
    }
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }
}

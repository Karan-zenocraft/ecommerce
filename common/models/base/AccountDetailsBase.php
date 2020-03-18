<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "account_details".
*
    * @property integer $id
    * @property integer $user_id
    * @property integer $account_type
    * @property string $paypal_email
    * @property string $stripe_bank_account_holder_name
    * @property string $stripe_bank_account_holder_type
    * @property integer $stripe_bank_routing_number
    * @property integer $stripe_bank_account_number
    * @property string $stripe_bank_token
    * @property string $stripe_connect_account_id
    * @property string $stripe_bank_accout_id
    * @property string $created_at
    * @property string $updated_at
*/
class AccountDetailsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'account_details';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['user_id', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'account_type', 'stripe_bank_routing_number', 'stripe_bank_account_number'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['paypal_email', 'stripe_bank_account_holder_name', 'stripe_bank_account_holder_type', 'stripe_bank_token', 'stripe_connect_account_id', 'stripe_bank_accout_id'], 'string', 'max' => 255],
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
    'account_type' => 'Account Type',
    'paypal_email' => 'Paypal Email',
    'stripe_bank_account_holder_name' => 'Stripe Bank Account Holder Name',
    'stripe_bank_account_holder_type' => 'Stripe Bank Account Holder Type',
    'stripe_bank_routing_number' => 'Stripe Bank Routing Number',
    'stripe_bank_account_number' => 'Stripe Bank Account Number',
    'stripe_bank_token' => 'Stripe Bank Token',
    'stripe_connect_account_id' => 'Stripe Connect Account ID',
    'stripe_bank_accout_id' => 'Stripe Bank Accout ID',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
     * @inheritdoc
     * @return AccountDetailsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AccountDetailsQuery(get_called_class());
}
}
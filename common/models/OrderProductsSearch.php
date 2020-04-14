<?php

namespace common\models;

use common\models\OrderProducts;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrderProductsSearch represents the model behind the search form of `common\models\OrderProducts`.
 */
class OrderProductsSearch extends OrderProducts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'product_id', 'quantity', 'seller_id'], 'integer'],
            [['actual_price', 'price_with_quantity', 'discount', 'tax', 'discounted_price', 'total_price_with_tax_discount', 'seller_amount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = OrderProducts::find()->where(['order_id' => $params['order_id']]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'product_id' => $this->product_id,
            'actual_price' => $this->actual_price,
            'price_with_quantity' => $this->price_with_quantity,
            'quantity' => $this->quantity,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'discounted_price' => $this->discounted_price,
            'total_price_with_tax_discount' => $this->total_price_with_tax_discount,
            'seller_id' => $this->seller_id,
            'seller_amount' => $this->seller_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}

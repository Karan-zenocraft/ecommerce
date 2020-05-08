<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InventoryProducts;

/**
 * InventoryProductsSearch represents the model behind the search form of `common\models\InventoryProducts`.
 */
class InventoryProductsSearch extends InventoryProducts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'category_id', 'current_value', 'replacement_value'], 'integer'],
            [['product_name', 'serial_no', 'note', 'purchase_date', 'purchased_from', 'is_warranty', 'warranty_start_date', 'warranty_end_date', 'status', 'created_at', 'updated_at'], 'safe'],
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
        $query = InventoryProducts::find()->where(['user_id'=>$params['uid']]);

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
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'purchase_date' => $this->purchase_date,
            'is_warranty' => $this->is_warranty,
            'current_value' => $this->current_value,
            'replacement_value' => $this->replacement_value,
            'warranty_start_date' => $this->warranty_start_date,
            'warranty_end_date' => $this->warranty_end_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'serial_no', $this->serial_no])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'purchased_from', $this->purchased_from])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}

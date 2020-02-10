<?php

namespace common\models;

use common\models\Products;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProductsSearch represents the model behind the search form of `common\models\Products`.
 */
class ProductsSearch extends Products
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'price', 'rent_price', 'rent_price_duration', 'quantity', 'status'], 'integer'],
            [['title', 'description', 'location_address', 'is_rent', 'created_at', 'updated_at', 'seller_id'], 'safe'],
            [['lat', 'longg'], 'number'],
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
        $query = Products::find();

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
            'category_id' => $this->category_id,
            'lat' => $this->lat,
            'longg' => $this->longg,
            'price' => $this->price,
            'rent_price' => $this->rent_price,
            'rent_price_duration' => $this->rent_price_duration,
            'quantity' => $this->quantity,
            'products.status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'location_address', $this->location_address])
            ->andFilterWhere(['like', 'is_rent', $this->is_rent]);
        $query->joinWith(['seller' => function ($query) {
            $query->where('CONCAT(users.first_name," ", users.last_name) LIKE "%' . $this->seller_id . '%"');
        }]);

        return $dataProvider;
    }
}

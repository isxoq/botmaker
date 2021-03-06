<?php

namespace frontend\modules\ecommerce\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\ecommerce\models\Order;

/**
 * OrderSearch represents the model behind the search form of `frontend\modules\ecommerce\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bot_id', 'created_at', 'user_id', 'status', 'total_price', 'payment_status', 'payment_type'], 'integer'],
            [['comment'], 'safe'],
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
        $query = Order::find();

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
            'bot_id' => $this->bot_id,
            'created_at' => $this->created_at,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'total_price' => $this->total_price,
            'payment_status' => $this->payment_status,
            'payment_type' => $this->payment_type,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);
        $query->andFilterWhere(['!=', 'order.status', self::STATUS_ORDERING]);

        return $dataProvider;
    }
}

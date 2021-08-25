<?php

namespace frontend\modules\info\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\ecommerce\models\BotUser;

/**
 * BotUserSearch represents the model behind the search form of `frontend\modules\ecommerce\models\BotUser`.
 */
class BotUserSearch extends BotUser
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bot_id', 'last_action_date', 'status'], 'integer'],
            [['user_id', 'username', 'phone', 'full_name'], 'safe'],
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
        $query = BotUser::find();

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
            'last_action_date' => $this->last_action_date,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'full_name', $this->full_name]);

        return $dataProvider;
    }
}

<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Esp;

/**
 * EspSearch represents the model behind the search form of `app\models\Esp`.
 */
class EspSearch extends Esp
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'valve', 'liter_base', 'liter_balance', 'liter_all_time', 'liter_from_esp', 'market_point'], 'string'],
            [['customer', 'address', 'drink_name', 'customer_name', 'esp_date_import', 'esp_last_date'], 'safe'],
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
    public function search($params, $param = null)
    {
        $query = Esp::find();

        if(isset($param) && !empty($param)){
            $query = $param;
        }

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
            'market_point' => $this->market_point,
            'valve' => $this->valve,
            'liter_base' => $this->liter_base,
            'liter_balance' => $this->liter_balance,
            'liter_all_time' => $this->liter_all_time,
            'liter_from_esp' => $this->liter_from_esp,
            'customer' => $this->customer,
            'address' => $this->address,
            'drink_name' => $this->drink_name,
            'customer_name' => $this->customer_name,
            'esp_date_import' => $this->esp_date_import,
            'esp_last_date' => $this->esp_last_date,
        ]);

        $query->andFilterWhere(['like', 'customer', $this->customer]);
        $query->andFilterWhere(['like', 'customer_name', $this->customer_name]);
        $query->andFilterWhere(['like', 'drink_name', $this->drink_name]);
        $query->andFilterWhere(['like', 'address', $this->address]);
        $query->andFilterWhere(['like', 'market_point', $this->market_point]);

        return $dataProvider;
    }

}

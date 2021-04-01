<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Drink;

/**
 * DrinkSearch represents the model behind the search form of `app\models\Drink`.
 */
class DrinkSearch extends Drink
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'group'], 'integer'],
            [['drink'], 'safe'],
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
        $query = Drink::find();

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
            'group' => $this->group,
        ]);

        $query->andFilterWhere(['like', 'drink', $this->drink]);

        return $dataProvider;
    }
}

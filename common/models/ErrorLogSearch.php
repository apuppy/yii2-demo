<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ErrorLog;

/**
 * ErrorLogSearch represents the model behind the search form of `common\models\ErrorLog`.
 */
class ErrorLogSearch extends ErrorLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'code'], 'integer'],
            [['module', 'level', 'message', 'file', 'trace', 'created_date', 'created_at'], 'safe'],
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
        $query = ErrorLog::find()->orderBy('id DESC');

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
            'code' => $this->code,
            'created_date' => $this->created_date,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'module', $this->module])
            ->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'trace', $this->trace]);

        return $dataProvider;
    }
}

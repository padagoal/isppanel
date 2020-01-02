<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Depositos;

/**
 * DepositosBuscar represents the model behind the search form about `app\models\Depositos`.
 */
class DepositosBuscar extends Depositos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cuenta', 'fecha', 'created_by', 'created_at', 'modified_by', 'modified_at'], 'safe'],
            [['numero', 'monto'], 'number'],
            [['verificado'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
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
	 
    public function search($params, $extraparams = null)
    {
        $query = Depositos::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if ($extraparams !== null) {
            foreach ($extraparams as $key => $value) {
                $query->andFilterWhere([$key => $value]);
            }
        }
        $query->andFilterWhere([
            'numero' => $this->numero,
            'monto' => $this->monto,
            'fecha' => $this->fecha,
            'verificado' => $this->verificado,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'cuenta', $this->cuenta])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'modified_by', $this->modified_by]);

        return $dataProvider;
    }
}

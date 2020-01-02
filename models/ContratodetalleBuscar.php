<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Contratodetalle;

/**
 * ContratodetalleBuscar represents the model behind the search form about `app\models\Contratodetalle`.
 */
class ContratodetalleBuscar extends Contratodetalle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresa', 'contrato', 'producto', 'fechainicio', 'fechafin', 'estado', 'observaciones', 'created_by', 'created_at', 'modified_by', 'modified_at'], 'safe'],
            [['monto', 'cantidad', 'cuotas'], 'number'],
            [['candowngrade', 'adicionalalplan'], 'boolean'],
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
        $query = Contratodetalle::find();

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
            'fechainicio' => $this->fechainicio,
            'fechafin' => $this->fechafin,
            'monto' => $this->monto,
            'cantidad' => $this->cantidad,
            'cuotas' => $this->cuotas,
            'candowngrade' => $this->candowngrade,
            'adicionalalplan' => $this->adicionalalplan,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'empresa', $this->empresa])
            ->andFilterWhere(['like', 'contrato', $this->contrato])
            ->andFilterWhere(['like', 'producto', $this->producto])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'modified_by', $this->modified_by]);

        return $dataProvider;
    }
}

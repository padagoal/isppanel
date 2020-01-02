<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Contrato;

/**
 * ContratoBuscar represents the model behind the search form about `app\models\Contrato`.
 */
class ContratoBuscar extends Contrato
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresa', 'contrato', 'clienteid', 'plan', 'promocion', 'financiacion', 'estado', 'fechainicio', 'fechafin', 'parametros', 'observaciones', 'created_by', 'created_at', 'modified_by', 'modified_at', 'modalidad','fechainstalacion'], 'safe'],
            [['vendedor'], 'integer'],
            [['equipos', 'duracion', 'diavto'], 'number'],
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
        $query = Contrato::find();

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
            'vendedor' => $this->vendedor,
            'fechainicio' => $this->fechainicio,
            'fechainstalacion' => $this->fechainstalacion,

            'fechafin' => $this->fechafin,
            'equipos' => $this->equipos,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
            'duracion' => $this->duracion,
            'diavto' => $this->diavto,
        ]);

        $query->andFilterWhere(['like', 'empresa', $this->empresa])
            ->andFilterWhere(['like', 'contrato', $this->contrato])
            ->andFilterWhere(['like', 'clienteid', $this->clienteid])
            ->andFilterWhere(['like', 'plan', $this->plan])
            ->andFilterWhere(['like', 'promocion', $this->promocion])
            ->andFilterWhere(['like', 'financiacion', $this->financiacion])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'parametros', $this->parametros])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'modified_by', $this->modified_by])
            ->andFilterWhere(['like', 'modalidad', $this->modalidad]);

        return $dataProvider;
    }
}

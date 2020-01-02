<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Serviciocliente;

/**
 * ServicioclientetBuscar represents the model behind the search form about `app\models\Serviciocliente`.
 */
class ServicioclientetBuscar extends Serviciocliente
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresa', 'contrato', 'servicio', 'fechasolicitud', 'fecharealizacion', 'callcenter', 'estado', 'ubicacion', 'observaciones', 'created_by', 'created_at', 'modified_by', 'modified_at'], 'safe'],
            [['realizado'], 'boolean'],
            [['tecnico'], 'integer'],
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
        $query = Serviciocliente::find();

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
            'fechasolicitud' => $this->fechasolicitud,
            'fecharealizacion' => $this->fecharealizacion,
            'realizado' => $this->realizado,
            'tecnico' => $this->tecnico,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'empresa', $this->empresa])
            ->andFilterWhere(['like', 'contrato', $this->contrato])
            ->andFilterWhere(['like', 'servicio', $this->servicio])
            ->andFilterWhere(['like', 'callcenter', $this->callcenter])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'ubicacion', $this->ubicacion])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'modified_by', $this->modified_by]);

        return $dataProvider;
    }
}

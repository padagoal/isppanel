<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Clientes;

/**
 * ClientesBuscar represents the model behind the search form about `app\models\Clientes`.
 */
class ClientesBuscar extends Clientes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresa', 'clienteid', 'cliente', 'contrato', 'cedula', 'direccion', 'zona', 'celular', 'whatsapp', 'localizacion', 'lat', 'lon', 'fechainicio', 'fechacontrato', 'estado', 'nir', 'ccc', 'observaciones', 'created_by', 'created_at', 'modified_by', 'modified_at'], 'safe'],
            [['diadecorte', 'monto', 'orden'], 'number'],
            [['callcenter', 'vendedor'], 'integer'],
            [['pordefecto', 'interno'], 'boolean'],
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
        $query = Clientes::find();

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
            'fechacontrato' => $this->fechacontrato,
            'diadecorte' => $this->diadecorte,
            'callcenter' => $this->callcenter,
            'vendedor' => $this->vendedor,
            'monto' => $this->monto,
            'pordefecto' => $this->pordefecto,
            'interno' => $this->interno,
            'orden' => $this->orden,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'empresa', $this->empresa])
            ->andFilterWhere(['like', 'clienteid', $this->clienteid])
            ->andFilterWhere(['like', 'cliente', $this->cliente])
            ->andFilterWhere(['like', 'contrato', $this->contrato])
            ->andFilterWhere(['like', 'cedula', $this->cedula])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'zona', $this->zona])
            ->andFilterWhere(['like', 'celular', $this->celular])
            ->andFilterWhere(['like', 'whatsapp', $this->whatsapp])
            ->andFilterWhere(['like', 'localizacion', $this->localizacion])
            ->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'lon', $this->lon])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'nir', $this->nir])
            ->andFilterWhere(['like', 'ccc', $this->ccc])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'modified_by', $this->modified_by]);

        return $dataProvider;
    }
}

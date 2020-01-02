<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Producto;

/**
 * ProductoBuscar represents the model behind the search form about `app\models\Producto`.
 */
class ProductoBuscar extends Producto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresa', 'producto', 'grupo', 'descripcion', 'formaciclo', 'observaciones', 'created_by', 'created_at', 'modified_by', 'modified_at', 'subgrupoproducto'], 'safe'],
            [['precio', 'maximo', 'cantidadciclo', 'orden'], 'number'],
            [['ciclico', 'pordefecto', 'interno', 'financiable', 'puededescuento'], 'boolean'],
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
        $query = Producto::find();

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
            'precio' => $this->precio,
            'maximo' => $this->maximo,
            'ciclico' => $this->ciclico,
            'cantidadciclo' => $this->cantidadciclo,
            'pordefecto' => $this->pordefecto,
            'interno' => $this->interno,
            'orden' => $this->orden,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
            'financiable' => $this->financiable,
            'puededescuento' => $this->puededescuento,
        ]);

        $query->andFilterWhere(['like', 'empresa', $this->empresa])
            ->andFilterWhere(['like', 'producto', $this->producto])
            ->andFilterWhere(['like', 'grupo', $this->grupo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'formaciclo', $this->formaciclo])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'modified_by', $this->modified_by])
            ->andFilterWhere(['like', 'subgrupoproducto', $this->subgrupoproducto]);

        return $dataProvider;
    }
}

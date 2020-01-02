<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Promocion;

/**
 * PromocionBuscar represents the model behind the search form about `app\models\Promocion`.
 */
class PromocionBuscar extends Promocion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresa', 'promocion', 'estado', 'fechadesde', 'fechahasta', 'observaciones', 'created_by', 'created_at', 'modified_by', 'modified_at'], 'safe'],
            [['interno'], 'boolean'],
            [['orden'], 'number'],
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
        $query = Promocion::find();

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
            'fechadesde' => $this->fechadesde,
            'fechahasta' => $this->fechahasta,
            'interno' => $this->interno,
            'orden' => $this->orden,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'empresa', $this->empresa])
            ->andFilterWhere(['like', 'promocion', $this->promocion])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'modified_by', $this->modified_by]);

        return $dataProvider;
    }
}

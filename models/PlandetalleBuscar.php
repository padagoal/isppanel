<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Plandetalle;

/**
 * PlandetalleBuscar represents the model behind the search form about `app\models\Plandetalle`.
 */
class PlandetalleBuscar extends Plandetalle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresa', 'plan', 'producto', 'observaciones', 'created_by', 'created_at', 'modified_by', 'modified_at'], 'safe'],
            [['cantidad', 'maximo', 'orden'], 'number'],
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
        $query = Plandetalle::find();

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
            'cantidad' => $this->cantidad,
            'maximo' => $this->maximo,
            'pordefecto' => $this->pordefecto,
            'interno' => $this->interno,
            'orden' => $this->orden,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'empresa', $this->empresa])
            ->andFilterWhere(['like', 'plan', $this->plan])
            ->andFilterWhere(['like', 'producto', $this->producto])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'modified_by', $this->modified_by]);

        return $dataProvider;
    }
}

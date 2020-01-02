<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Seguimiento;

/**
 * SeguimientoBuscar represents the model behind the search form about `app\models\Seguimiento`.
 */
class SeguimientoBuscar extends Seguimiento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['seguimientoid', 'vendedor'], 'integer'],
            [['empresa', 'clienteid', 'fecha', 'seguimiento', 'comentario', 'created_by', 'created_at', 'modified_by', 'modified_at'], 'safe'],
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
        $query = Seguimiento::find();

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
            'seguimientoid' => $this->seguimientoid,
            'vendedor' => $this->vendedor,
            'fecha' => $this->fecha,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'empresa', $this->empresa])
            ->andFilterWhere(['like', 'clienteid', $this->clienteid])
            ->andFilterWhere(['like', 'seguimiento', $this->seguimiento])
            ->andFilterWhere(['like', 'comentario', $this->comentario])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'modified_by', $this->modified_by]);

        return $dataProvider;
    }
}

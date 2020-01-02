<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Olt;

/**
 * OltBuscar represents the model behind the search form about `app\models\Olt`.
 */
class OltBuscar extends Olt
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['oltid'], 'number'],
            [['empresa', 'nombre'], 'safe'],
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
        $query = Olt::find();

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
            'oltid' => $this->oltid,
        ]);

        $query->andFilterWhere(['like', 'empresa', $this->empresa])
            ->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }
}

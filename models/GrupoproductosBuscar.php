<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Grupoproductos;

/**
 * GrupoproductosBuscar represents the model behind the search form about `app\models\Grupoproductos`.
 */
class GrupoproductosBuscar extends Grupoproductos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grupo'], 'safe'],
            [['maximo'], 'number'],
            [['servicio'], 'boolean'],
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
        $query = Grupoproductos::find();

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
            'maximo' => $this->maximo,
            'servicio' => $this->servicio,
        ]);

        $query->andFilterWhere(['like', 'grupo', $this->grupo]);

        return $dataProvider;
    }
}

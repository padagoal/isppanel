<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Recibo;

/**
 * ReciboBuscar represents the model behind the search form about `app\models\Recibo`.
 */
class ReciboBuscar extends Recibo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numerorecibo', 'cobrador'], 'integer'],
            [['empresa', 'clienteid', 'estadopago', 'fechaemision', 'created_by', 'created_at', 'modified_by', 'modified_at'], 'safe'],
            [['numero'], 'number'],
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
        $query = Recibo::find();

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
            'numerorecibo' => $this->numerorecibo,
            'numero' => $this->numero,
            'cobrador' => $this->cobrador,
            'fechaemision' => $this->fechaemision,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'empresa', $this->empresa])
            ->andFilterWhere(['like', 'clienteid', $this->clienteid])
            ->andFilterWhere(['like', 'estadopago', $this->estadopago])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'modified_by', $this->modified_by]);

        return $dataProvider;
    }
}

<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Recibodetalle;

/**
 * RecibodetalleBuscar represents the model behind the search form about `app\models\Recibodetalle`.
 */
class RecibodetalleBuscar extends Recibodetalle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numerorecibo', 'estadocuentaid'], 'integer'],
            [['empresa', 'clienteid', 'periodo', 'tipopago', 'created_by', 'created_at', 'modified_by', 'modified_at'], 'safe'],
            [['monto'], 'number'],
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
        $query = Recibodetalle::find();

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
            'estadocuentaid' => $this->estadocuentaid,
            'monto' => $this->monto,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'empresa', $this->empresa])
            ->andFilterWhere(['like', 'clienteid', $this->clienteid])
            ->andFilterWhere(['like', 'periodo', $this->periodo])
            ->andFilterWhere(['like', 'tipopago', $this->tipopago])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'modified_by', $this->modified_by]);

        return $dataProvider;
    }
}

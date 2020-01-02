<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Servicioclientedetalle;

/**
 * ServicioclientedetalleBuscar represents the model behind the search form about `app\models\Servicioclientedetalle`.
 */
class ServicioclientedetalleBuscar extends Servicioclientedetalle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresa', 'producto', 'contrato', 'tiposervicio', 'fechasolicitud'], 'safe'],
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
        $query = Servicioclientedetalle::find();

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
        ]);

        $query->andFilterWhere(['like', 'empresa', $this->empresa])
            ->andFilterWhere(['like', 'producto', $this->producto])
            ->andFilterWhere(['like', 'contrato', $this->contrato])
            ->andFilterWhere(['like', 'tiposervicio', $this->tiposervicio]);

        return $dataProvider;
    }
}

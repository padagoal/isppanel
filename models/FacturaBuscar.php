<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Factura;

/**
 * FacturaBuscar represents the model behind the search form about `app\models\Factura`.
 */
class FacturaBuscar extends Factura
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numerofactura'], 'integer'],
            [['empresa', 'numfactura', 'clienteid', 'estadopago', 'cliente', 'fechaemision', 'fechavto', 'tipofactura', 'created_by', 'created_at', 'modified_by', 'modified_at'], 'safe'],
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
        $query = Factura::find();

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
            'numerofactura' => $this->numerofactura,
            'fechaemision' => $this->fechaemision,
            'fechavto' => $this->fechavto,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'empresa', $this->empresa])
            ->andFilterWhere(['like', 'numfactura', $this->numfactura])
            ->andFilterWhere(['like', 'clienteid', $this->clienteid])
            ->andFilterWhere(['like', 'estadopago', $this->estadopago])
            ->andFilterWhere(['like', 'cliente', $this->cliente])
            ->andFilterWhere(['like', 'tipofactura', $this->tipofactura])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'modified_by', $this->modified_by]);

        return $dataProvider;
    }
}

<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Userprofile;

/**
 * UserprofileBuscar represents the model behind the search form about `\app\models\Userprofile`.
 */
class UserprofileBuscar extends Userprofile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile'], 'safe'],
            [['internal'], 'boolean'],
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
    public function search($params)
    {
        $query = Userprofile::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'internal' => $this->internal,
        ]);

        $query->andFilterWhere(['like', 'profile', $this->profile]);

        return $dataProvider;
    }
}

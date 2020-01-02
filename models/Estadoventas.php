<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estadoventas".
 *
 * @property string $estado
 *
 * @property Contrato[] $contratos
 */
class Estadoventas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadoventas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado'], 'required'],
            [['estado'], 'string', 'max' => 20],
            [['estado'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'estado' => Yii::t('app', 'Estado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratos()
    {
        return $this->hasMany(Contrato::className(), ['estado' => 'estado']);
    }
}

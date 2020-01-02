<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estadoservicios".
 *
 * @property string $estado
 *
 * @property Serviciocliente[] $servicioclientes
 */
class Estadoservicios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadoservicios';
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
    public function getServicioclientes()
    {
        return $this->hasMany(Serviciocliente::className(), ['estado' => 'estado']);
    }
}

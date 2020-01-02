<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "periodos".
 *
 * @property string $periodo
 * @property string $fechainicio
 * @property string $fechafin
 *
 * @property Estadocuenta[] $estadocuentas
 */
class Periodos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'periodos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['periodo', 'fechainicio', 'fechafin'], 'required'],
            [['fechainicio', 'fechafin'], 'safe'],
            [['periodo'], 'string', 'max' => 10],
            [['periodo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'periodo' => Yii::t('app', 'Periodo'),
            'fechainicio' => Yii::t('app', 'Fechainicio'),
            'fechafin' => Yii::t('app', 'Fechafin'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadocuentas()
    {
        return $this->hasMany(Estadocuenta::className(), ['periodo' => 'periodo']);
    }
}

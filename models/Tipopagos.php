<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipopagos".
 *
 * @property string $tipopago
 * @property string $monto
 *
 * @property Estadocuenta[] $estadocuentas
 */
class Tipopagos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipopagos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipopago'], 'required'],
            [['monto'], 'number'],
            [['tipopago'], 'string', 'max' => 100],
            [['tipopago'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tipopago' => Yii::t('app', 'Tipopago'),
            'monto' => Yii::t('app', 'Monto'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadocuentas()
    {
        return $this->hasMany(Estadocuenta::className(), ['tipopago' => 'tipopago']);
    }
}

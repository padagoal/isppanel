<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estadopagos".
 *
 * @property string $estadopago
 *
 * @property Estadocuenta[] $estadocuentas
 * @property Factura[] $facturas
 * @property Recibo[] $recibos
 */
class Estadopagos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadopagos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estadopago'], 'required'],
            [['estadopago'], 'string', 'max' => 20],
            [['estadopago'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'estadopago' => Yii::t('app', 'Estadopago'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadocuentas()
    {
        return $this->hasMany(Estadocuenta::className(), ['estadopago' => 'estadopago']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturas()
    {
        return $this->hasMany(Factura::className(), ['estadopago' => 'estadopago']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecibos()
    {
        return $this->hasMany(Recibo::className(), ['estadopago' => 'estadopago']);
    }
}

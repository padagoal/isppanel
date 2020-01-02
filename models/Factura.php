<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "factura".
 *
 * @property int $numerofactura
 * @property string $empresa
 * @property string $numfactura
 * @property string $clienteid
 * @property string $estadopago
 * @property string $cliente
 * @property string $fechaemision
 * @property string $fechavto
 * @property string $tipofactura Contado Credit EContado ECredito
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 *
 * @property Estadocuenta[] $estadocuentas
 * @property Clientes $empresa0
 * @property Estadopagos $estadopago0
 */
class Factura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'factura';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'numfactura', 'tipofactura', 'created_by'], 'required'],
            [['fechaemision', 'fechavto', 'created_at', 'modified_at'], 'safe'],
            [['empresa', 'clienteid', 'cliente', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['numfactura', 'estadopago', 'tipofactura'], 'string', 'max' => 20],
            [['numfactura', 'empresa'], 'unique', 'targetAttribute' => ['numfactura', 'empresa']],
            [['empresa', 'clienteid'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['empresa' => 'empresa', 'clienteid' => 'clienteid']],
            [['estadopago'], 'exist', 'skipOnError' => true, 'targetClass' => Estadopagos::className(), 'targetAttribute' => ['estadopago' => 'estadopago']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'numerofactura' => Yii::t('app', 'Numerofactura'),
            'empresa' => Yii::t('app', 'Empresa'),
            'numfactura' => Yii::t('app', 'Numfactura'),
            'clienteid' => Yii::t('app', 'Clienteid'),
            'estadopago' => Yii::t('app', 'Estadopago'),
            'cliente' => Yii::t('app', 'Cliente'),
            'fechaemision' => Yii::t('app', 'Fechaemision'),
            'fechavto' => Yii::t('app', 'Fechavto'),
            'tipofactura' => Yii::t('app', 'Tipofactura'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadocuentas()
    {
        return $this->hasMany(Estadocuenta::className(), ['numerofactura' => 'numerofactura']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa0()
    {
        return $this->hasOne(Clientes::className(), ['empresa' => 'empresa', 'clienteid' => 'clienteid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadopago0()
    {
        return $this->hasOne(Estadopagos::className(), ['estadopago' => 'estadopago']);
    }
}

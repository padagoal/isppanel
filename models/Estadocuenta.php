<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estadocuenta".
 *
 * @property int $estadocuentaid
 * @property string $empresa
 * @property string $contrato
 * @property string $producto
 * @property string $fechainicio
 * @property string $periodo
 * @property string $tipopago
 * @property int $numerofactura
 * @property string $vencimiento
 * @property string $estadopago
 * @property string $monto
 * @property string $numerorecibo
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 *
 * @property Contratodetalle $empresa0
 * @property Estadopagos $estadopago0
 * @property Factura $numerofactura0
 * @property Periodos $periodo0
 * @property Tipopagos $tipopago0
 */
class Estadocuenta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadocuenta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'contrato', 'producto', 'periodo', 'tipopago', 'vencimiento', 'estadopago', 'created_at', 'modified_at'], 'required'],
            [['fechainicio', 'vencimiento', 'created_at', 'modified_at'], 'safe'],
            [['numerofactura'], 'default', 'value' => null],
            [['numerofactura'], 'integer'],
            [['monto', 'numerorecibo'], 'number'],
            [['empresa', 'contrato', 'producto', 'tipopago', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['periodo'], 'string', 'max' => 10],
            [['estadopago'], 'string', 'max' => 20],
            [['empresa', 'contrato', 'producto', 'fechainicio'], 'exist', 'skipOnError' => true, 'targetClass' => Contratodetalle::className(), 'targetAttribute' => ['empresa' => 'empresa', 'contrato' => 'contrato', 'producto' => 'producto', 'fechainicio' => 'fechainicio']],
            [['estadopago'], 'exist', 'skipOnError' => true, 'targetClass' => Estadopagos::className(), 'targetAttribute' => ['estadopago' => 'estadopago']],
            [['numerofactura'], 'exist', 'skipOnError' => true, 'targetClass' => Factura::className(), 'targetAttribute' => ['numerofactura' => 'numerofactura']],
            [['periodo'], 'exist', 'skipOnError' => true, 'targetClass' => Periodos::className(), 'targetAttribute' => ['periodo' => 'periodo']],
            [['tipopago'], 'exist', 'skipOnError' => true, 'targetClass' => Tipopagos::className(), 'targetAttribute' => ['tipopago' => 'tipopago']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'estadocuentaid' => Yii::t('app', 'Estadocuentaid'),
            'empresa' => Yii::t('app', 'Empresa'),
            'contrato' => Yii::t('app', 'Contrato'),
            'producto' => Yii::t('app', 'Producto'),
            'fechainicio' => Yii::t('app', 'Fechainicio'),
            'periodo' => Yii::t('app', 'Periodo'),
            'tipopago' => Yii::t('app', 'Tipopago'),
            'numerofactura' => Yii::t('app', 'Numerofactura'),
            'vencimiento' => Yii::t('app', 'Vencimiento'),
            'estadopago' => Yii::t('app', 'Estadopago'),
            'monto' => Yii::t('app', 'Monto'),
            'numerorecibo' => Yii::t('app', 'Numerorecibo'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa0()
    {
        return $this->hasOne(Contratodetalle::className(), ['empresa' => 'empresa', 'contrato' => 'contrato', 'producto' => 'producto', 'fechainicio' => 'fechainicio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadopago0()
    {
        return $this->hasOne(Estadopagos::className(), ['estadopago' => 'estadopago']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNumerofactura0()
    {
        return $this->hasOne(Factura::className(), ['numerofactura' => 'numerofactura']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriodo0()
    {
        return $this->hasOne(Periodos::className(), ['periodo' => 'periodo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipopago0()
    {
        return $this->hasOne(Tipopagos::className(), ['tipopago' => 'tipopago']);
    }
}

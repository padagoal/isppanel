<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "promociondetalle".
 *
 * @property string $empresa
 * @property string $producto
 * @property string $plan
 * @property string $promocion
 * @property string $formadescuento
 * @property string $cuotas
 * @property string $descuento
 * @property string $observaciones
 * @property bool $pordefecto
 * @property bool $interno
 * @property string $orden
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 *
 * @property Formasdescuento $formadescuento0
 * @property Plandetalle $empresa0
 * @property Promocion $empresa1
 */
class Promociondetalle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promociondetalle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'producto', 'plan', 'promocion', 'cuotas', 'created_by'], 'required'],
            [['cuotas', 'descuento', 'orden'], 'number'],
            [['observaciones'], 'string'],
            [['pordefecto', 'interno'], 'boolean'],
            [['created_at', 'modified_at'], 'safe'],
            [['empresa', 'producto', 'plan', 'promocion', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['formadescuento'], 'string', 'max' => 30],
            [['empresa', 'producto', 'plan', 'promocion'], 'unique', 'targetAttribute' => ['empresa', 'producto', 'plan', 'promocion']],
            [['formadescuento'], 'exist', 'skipOnError' => true, 'targetClass' => Formasdescuento::className(), 'targetAttribute' => ['formadescuento' => 'formadescuento']],
            [['empresa', 'producto', 'plan'], 'exist', 'skipOnError' => true, 'targetClass' => Plandetalle::className(), 'targetAttribute' => ['empresa' => 'empresa', 'producto' => 'producto', 'plan' => 'plan']],
            [['empresa', 'promocion'], 'exist', 'skipOnError' => true, 'targetClass' => Promocion::className(), 'targetAttribute' => ['empresa' => 'empresa', 'promocion' => 'promocion']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'empresa' => Yii::t('app', 'Empresa'),
            'producto' => Yii::t('app', 'Producto'),
            'plan' => Yii::t('app', 'Plan'),
            'promocion' => Yii::t('app', 'Promocion'),
            'formadescuento' => Yii::t('app', 'Formadescuento'),
            'cuotas' => Yii::t('app', 'Cuotas'),
            'descuento' => Yii::t('app', 'Descuento'),
            'observaciones' => Yii::t('app', 'Observaciones'),
            'pordefecto' => Yii::t('app', 'Pordefecto'),
            'interno' => Yii::t('app', 'Interno'),
            'orden' => Yii::t('app', 'Orden'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormadescuento0()
    {
        return $this->hasOne(Formasdescuento::className(), ['formadescuento' => 'formadescuento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa0()
    {
        return $this->hasOne(Plandetalle::className(), ['empresa' => 'empresa', 'producto' => 'producto', 'plan' => 'plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa1()
    {
        return $this->hasOne(Promocion::className(), ['empresa' => 'empresa', 'promocion' => 'promocion']);
    }
}

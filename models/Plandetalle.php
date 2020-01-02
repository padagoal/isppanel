<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plandetalle".
 *
 * @property string $empresa
 * @property string $plan
 * @property string $producto
 * @property string $cantidad
 * @property string $maximo
 * @property string $observaciones
 * @property bool $pordefecto
 * @property bool $interno
 * @property string $orden
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 *
 * @property Plan $empresa0
 * @property Producto $empresa1
 * @property Promociondetalle[] $promociondetalles
 * @property Promocion[] $empresas
 */
class Plandetalle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plandetalle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'plan', 'producto', 'cantidad', 'maximo', 'created_by'], 'required'],
            [['cantidad', 'maximo', 'orden'], 'number'],
            [['observaciones'], 'string'],
            [['pordefecto', 'interno'], 'boolean'],
            [['created_at', 'modified_at'], 'safe'],
            [['empresa', 'plan', 'producto', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['empresa', 'plan', 'producto'], 'unique', 'targetAttribute' => ['empresa', 'plan', 'producto']],
            [['empresa', 'plan'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['empresa' => 'empresa', 'plan' => 'plan']],
            [['empresa', 'producto'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['empresa' => 'empresa', 'producto' => 'producto']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'empresa' => Yii::t('app', 'Empresa'),
            'plan' => Yii::t('app', 'Plan'),
            'producto' => Yii::t('app', 'Producto'),
            'cantidad' => Yii::t('app', 'Cantidad'),
            'maximo' => Yii::t('app', 'Maximo'),
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
    public function getEmpresa0()
    {
        return $this->hasOne(Plan::className(), ['empresa' => 'empresa', 'plan' => 'plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa1()
    {
        return $this->hasOne(Producto::className(), ['empresa' => 'empresa', 'producto' => 'producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromociondetalles()
    {
        return $this->hasMany(Promociondetalle::className(), ['empresa' => 'empresa', 'producto' => 'producto', 'plan' => 'plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas()
    {
        return $this->hasMany(Promocion::className(), ['empresa' => 'empresa', 'promocion' => 'promocion'])->viaTable('promociondetalle', ['empresa' => 'empresa', 'producto' => 'producto', 'plan' => 'plan']);
    }
}

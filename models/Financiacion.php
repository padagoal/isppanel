<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "financiacion".
 *
 * @property string $empresa
 * @property string $financiacion
 * @property string $observaciones
 * @property bool $pordefecto
 * @property bool $interno
 * @property string $orden
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 * @property string $estado
 *
 * @property Contrato[] $contratos
 * @property Contratodetalle[] $contratodetalles
 * @property Empresas $empresa0
 * @property Estadofinanciacion $estado0
 * @property Financiaciondetalle[] $financiaciondetalles
 * @property Producto[] $productos
 * @property Financiaciondisponible[] $financiaciondisponibles
 * @property Plan[] $empresas
 */
class Financiacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'financiacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'financiacion', 'created_by'], 'required'],
            [['observaciones'], 'string'],
            [['pordefecto', 'interno'], 'boolean'],
            [['orden'], 'number'],
            [['created_at', 'modified_at'], 'safe'],
            [['empresa', 'financiacion', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['estado'], 'string', 'max' => 20],
            [['empresa', 'financiacion'], 'unique', 'targetAttribute' => ['empresa', 'financiacion']],
            [['empresa'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa' => 'empresa']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estadofinanciacion::className(), 'targetAttribute' => ['estado' => 'estado']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'empresa' => Yii::t('app', 'Empresa'),
            'financiacion' => Yii::t('app', 'Financiacion'),
            'observaciones' => Yii::t('app', 'Observaciones'),
            'pordefecto' => Yii::t('app', 'Pordefecto'),
            'interno' => Yii::t('app', 'Interno'),
            'orden' => Yii::t('app', 'Orden'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'modified_at' => Yii::t('app', 'Modified At'),
            'estado' => Yii::t('app', 'Estado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratos()
    {
        return $this->hasMany(Contrato::className(), ['empresa' => 'empresa', 'financiacion' => 'financiacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratodetalles()
    {
        return $this->hasMany(Contratodetalle::className(), ['empresa' => 'empresa', 'financiacion' => 'financiacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa0()
    {
        return $this->hasOne(Empresas::className(), ['empresa' => 'empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estadofinanciacion::className(), ['estado' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanciaciondetalles()
    {
        return $this->hasMany(Financiaciondetalle::className(), ['empresa' => 'empresa', 'financiacion' => 'financiacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Producto::className(), ['producto' => 'producto', 'empresa' => 'empresa'])->viaTable('financiaciondetalle', ['empresa' => 'empresa', 'financiacion' => 'financiacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanciaciondisponibles()
    {
        return $this->hasMany(Financiaciondisponible::className(), ['empresa' => 'empresa', 'financiacion' => 'financiacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas()
    {
        return $this->hasMany(Plan::className(), ['empresa' => 'empresa', 'plan' => 'plantv'])->viaTable('financiaciondisponible', ['empresa' => 'empresa', 'financiacion' => 'financiacion']);
    }
}

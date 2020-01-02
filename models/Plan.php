<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plan".
 *
 * @property string $empresa
 * @property string $plan
 * @property string $estado
 * @property string $monto
 * @property string $formaduracion
 * @property string $duracion Duracionforma: mensual DuracionSTB:1 -> ciclo de 1 mes.
 * @property string $fechainicio
 * @property string $fechafin
 * @property bool $interno
 * @property string $orden
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 * @property string $observaciones
 * @property string $modalidad
 *
 * @property Contrato[] $contratos
 * @property Contratodetalle[] $contratodetalles
 * @property Financiaciondisponible[] $financiaciondisponibles
 * @property Financiacion[] $empresas
 * @property Estadoplan $estado0
 * @property Formasduracion $formaduracion0
 * @property Plandetalle[] $plandetalles
 * @property Producto[] $empresas0
 * @property Promodisponible[] $promodisponibles
 * @property Promocion[] $empresas1
 */
class Plan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'plan', 'monto', 'created_by'], 'required'],
            [['monto', 'duracion', 'orden'], 'number'],
            [['fechainicio', 'fechafin', 'created_at', 'modified_at'], 'safe'],
            [['interno'], 'boolean'],
            [['observaciones'], 'string'],
            [['empresa', 'plan', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['estado', 'modalidad'], 'string', 'max' => 20],
            [['formaduracion'], 'string', 'max' => 30],
            [['empresa', 'plan'], 'unique', 'targetAttribute' => ['empresa', 'plan']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoplan::className(), 'targetAttribute' => ['estado' => 'estado']],
            [['formaduracion'], 'exist', 'skipOnError' => true, 'targetClass' => Formasduracion::className(), 'targetAttribute' => ['formaduracion' => 'formaduracion']],
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
            'estado' => Yii::t('app', 'Estado'),
            'monto' => Yii::t('app', 'Monto'),
            'formaduracion' => Yii::t('app', 'Formaduracion'),
            'duracion' => Yii::t('app', 'Duracion'),
            'fechainicio' => Yii::t('app', 'Fechainicio'),
            'fechafin' => Yii::t('app', 'Fechafin'),
            'interno' => Yii::t('app', 'Interno'),
            'orden' => Yii::t('app', 'Orden'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'modified_at' => Yii::t('app', 'Modified At'),
            'observaciones' => Yii::t('app', 'Observaciones'),
            'modalidad' => Yii::t('app', 'Modalidad'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratos()
    {
        return $this->hasMany(Contrato::className(), ['empresa' => 'empresa', 'plan' => 'plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratodetalles()
    {
        return $this->hasMany(Contratodetalle::className(), ['empresa' => 'empresa', 'plan' => 'plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanciaciondisponibles()
    {
        return $this->hasMany(Financiaciondisponible::className(), ['empresa' => 'empresa', 'plantv' => 'plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas()
    {
        return $this->hasMany(Financiacion::className(), ['empresa' => 'empresa', 'financiacion' => 'financiacion'])->viaTable('financiaciondisponible', ['empresa' => 'empresa', 'plantv' => 'plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estadoplan::className(), ['estado' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormaduracion0()
    {
        return $this->hasOne(Formasduracion::className(), ['formaduracion' => 'formaduracion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlandetalles()
    {
        return $this->hasMany(Plandetalle::className(), ['empresa' => 'empresa', 'plan' => 'plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas0()
    {
        return $this->hasMany(Producto::className(), ['empresa' => 'empresa', 'producto' => 'producto'])->viaTable('plandetalle', ['empresa' => 'empresa', 'plan' => 'plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromodisponibles()
    {
        return $this->hasMany(Promodisponible::className(), ['empresa' => 'empresa', 'plan' => 'plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas1()
    {
        return $this->hasMany(Promocion::className(), ['empresa' => 'empresa', 'promocion' => 'promocion'])->viaTable('promodisponible', ['empresa' => 'empresa', 'plan' => 'plan']);
    }
}

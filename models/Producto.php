<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "producto".
 *
 * @property string $empresa
 * @property string $producto
 * @property string $grupo
 * @property string $descripcion
 * @property string $precio
 * @property string $maximo
 * @property bool $ciclico
 * @property string $formaciclo
 * @property string $cantidadciclo
 * @property string $observaciones
 * @property bool $pordefecto
 * @property bool $interno
 * @property string $orden
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 * @property string $subgrupoproducto
 * @property bool $financiable
 * @property bool $puededescuento
 *
 * @property Contratodetalle[] $contratodetalles
 * @property Financiaciondetalle[] $financiaciondetalles
 * @property Financiacion[] $empresas
 * @property Plandetalle[] $plandetalles
 * @property Plan[] $empresas0
 * @property Empresas $empresa0
 * @property Formasciclo $formaciclo0
 * @property Grupoproductos $grupo0
 * @property Serviciocliente[] $servicioclientes
 */
class Producto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'producto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'producto', 'grupo', 'maximo', 'created_by'], 'required'],
            [['precio', 'maximo', 'cantidadciclo', 'orden'], 'number'],
            [['ciclico', 'pordefecto', 'interno', 'financiable', 'puededescuento'], 'boolean'],
            [['observaciones'], 'string'],
            [['created_at', 'modified_at'], 'safe'],
            [['empresa', 'producto', 'descripcion', 'formaciclo', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['grupo'], 'string', 'max' => 20],
            [['subgrupoproducto'], 'string', 'max' => 50],
            [['empresa', 'producto'], 'unique', 'targetAttribute' => ['empresa', 'producto']],
            [['empresa'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa' => 'empresa']],
            [['formaciclo'], 'exist', 'skipOnError' => true, 'targetClass' => Formasciclo::className(), 'targetAttribute' => ['formaciclo' => 'formaciclo']],
            [['grupo'], 'exist', 'skipOnError' => true, 'targetClass' => Grupoproductos::className(), 'targetAttribute' => ['grupo' => 'grupo']],
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
            'grupo' => Yii::t('app', 'Grupo'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'precio' => Yii::t('app', 'Precio'),
            'maximo' => Yii::t('app', 'Maximo'),
            'ciclico' => Yii::t('app', 'Ciclico'),
            'formaciclo' => Yii::t('app', 'Formaciclo'),
            'cantidadciclo' => Yii::t('app', 'Cantidadciclo'),
            'observaciones' => Yii::t('app', 'Observaciones'),
            'pordefecto' => Yii::t('app', 'Pordefecto'),
            'interno' => Yii::t('app', 'Interno'),
            'orden' => Yii::t('app', 'Orden'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'modified_at' => Yii::t('app', 'Modified At'),
            'subgrupoproducto' => Yii::t('app', 'Subgrupoproducto'),
            'financiable' => Yii::t('app', 'Financiable'),
            'puededescuento' => Yii::t('app', 'Puededescuento'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratodetalles()
    {
        return $this->hasMany(Contratodetalle::className(), ['empresa' => 'empresa', 'producto' => 'producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanciaciondetalles()
    {
        return $this->hasMany(Financiaciondetalle::className(), ['producto' => 'producto', 'empresa' => 'empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas()
    {
        return $this->hasMany(Financiacion::className(), ['empresa' => 'empresa', 'financiacion' => 'financiacion'])->viaTable('financiaciondetalle', ['producto' => 'producto', 'empresa' => 'empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlandetalles()
    {
        return $this->hasMany(Plandetalle::className(), ['empresa' => 'empresa', 'producto' => 'producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas0()
    {
        return $this->hasMany(Plan::className(), ['empresa' => 'empresa', 'plan' => 'plan'])->viaTable('plandetalle', ['empresa' => 'empresa', 'producto' => 'producto']);
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
    public function getFormaciclo0()
    {
        return $this->hasOne(Formasciclo::className(), ['formaciclo' => 'formaciclo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupo0()
    {
        return $this->hasOne(Grupoproductos::className(), ['grupo' => 'grupo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicioclientes()
    {
        return $this->hasMany(Serviciocliente::className(), ['empresa' => 'empresa', 'producto' => 'producto']);
    }
}

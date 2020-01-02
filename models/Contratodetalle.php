<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contratodetalle".
 *
 * @property string $empresa
 * @property string $contrato
 * @property string $producto
 * @property string $fechainicio
 * @property string $fechafin
 * @property string $estado
 * @property string $monto Monto Individual
 * @property string $cantidad
 * @property string $cuotas
 * @property bool $candowngrade
 * @property bool $adicionalalplan
 * @property string $observaciones
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 *
 * @property Contrato $empresa0
 * @property Producto $empresa1
 * @property Estadocuenta[] $estadocuentas
 */
class Contratodetalle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contratodetalle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'contrato', 'producto', 'fechainicio', 'cantidad', 'cuotas', 'created_by'], 'required'],
            [['fechainicio', 'fechafin', 'created_at', 'modified_at'], 'safe'],
            [['monto', 'cantidad', 'cuotas'], 'number'],
            [['candowngrade', 'adicionalalplan'], 'boolean'],
            [['observaciones'], 'string'],
            [['empresa', 'contrato', 'producto', 'estado', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['empresa', 'contrato', 'producto', 'fechainicio'], 'unique', 'targetAttribute' => ['empresa', 'contrato', 'producto', 'fechainicio']],
            [['empresa', 'contrato'], 'exist', 'skipOnError' => true, 'targetClass' => Contrato::className(), 'targetAttribute' => ['empresa' => 'empresa', 'contrato' => 'contrato']],
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
            'contrato' => Yii::t('app', 'Contrato'),
            'producto' => Yii::t('app', 'Producto'),
            'fechainicio' => Yii::t('app', 'Fechainicio'),
            'fechafin' => Yii::t('app', 'Fechafin'),
            'estado' => Yii::t('app', 'Estado'),
            'monto' => Yii::t('app', 'Monto'),
            'cantidad' => Yii::t('app', 'Cantidad'),
            'cuotas' => Yii::t('app', 'Cuotas'),
            'candowngrade' => Yii::t('app', 'Candowngrade'),
            'adicionalalplan' => Yii::t('app', 'Adicionalalplan'),
            'observaciones' => Yii::t('app', 'Observaciones'),
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
        return $this->hasOne(Contrato::className(), ['empresa' => 'empresa', 'contrato' => 'contrato']);
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
    public function getEstadocuentas()
    {
        return $this->hasMany(Estadocuenta::className(), ['empresa' => 'empresa', 'contrato' => 'contrato', 'producto' => 'producto', 'fechainicio' => 'fechainicio']);
    }
}

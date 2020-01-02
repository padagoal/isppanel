<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "financiaciondetalle".
 *
 * @property string $producto
 * @property string $empresa
 * @property string $financiacion
 * @property string $cuotas
 * @property string $intereses
 * @property string $observaciones
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 *
 * @property Financiacion $empresa0
 * @property Producto $producto0
 */
class Financiaciondetalle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'financiaciondetalle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto', 'empresa', 'financiacion', 'created_by'], 'required'],
            [['cuotas', 'intereses'], 'number'],
            [['observaciones'], 'string'],
            [['created_at', 'modified_at'], 'safe'],
            [['producto', 'empresa', 'financiacion', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['producto', 'empresa', 'financiacion'], 'unique', 'targetAttribute' => ['producto', 'empresa', 'financiacion']],
            [['empresa', 'financiacion'], 'exist', 'skipOnError' => true, 'targetClass' => Financiacion::className(), 'targetAttribute' => ['empresa' => 'empresa', 'financiacion' => 'financiacion']],
            [['producto', 'empresa'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['producto' => 'producto', 'empresa' => 'empresa']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'producto' => Yii::t('app', 'Producto'),
            'empresa' => Yii::t('app', 'Empresa'),
            'financiacion' => Yii::t('app', 'Financiacion'),
            'cuotas' => Yii::t('app', 'Cuotas'),
            'intereses' => Yii::t('app', 'Intereses'),
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
        return $this->hasOne(Financiacion::className(), ['empresa' => 'empresa', 'financiacion' => 'financiacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducto0()
    {
        return $this->hasOne(Producto::className(), ['producto' => 'producto', 'empresa' => 'empresa']);
    }
}

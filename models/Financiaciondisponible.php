<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "financiaciondisponible".
 *
 * @property string $empresa
 * @property string $plantv
 * @property string $financiacion
 * @property bool $obligatorio
 * @property string $observaciones
 * @property bool $pordefecto
 * @property bool $interno
 * @property string $orden
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 *
 * @property Financiacion $empresa0
 * @property Plan $empresa1
 */
class Financiaciondisponible extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'financiaciondisponible';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'plantv', 'financiacion', 'obligatorio', 'created_by'], 'required'],
            [['obligatorio', 'pordefecto', 'interno'], 'boolean'],
            [['observaciones'], 'string'],
            [['orden'], 'number'],
            [['created_at', 'modified_at'], 'safe'],
            [['empresa', 'plantv', 'financiacion', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['empresa', 'plantv', 'financiacion'], 'unique', 'targetAttribute' => ['empresa', 'plantv', 'financiacion']],
            [['empresa', 'financiacion'], 'exist', 'skipOnError' => true, 'targetClass' => Financiacion::className(), 'targetAttribute' => ['empresa' => 'empresa', 'financiacion' => 'financiacion']],
            [['empresa', 'plantv'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['empresa' => 'empresa', 'plantv' => 'plan']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'empresa' => Yii::t('app', 'Empresa'),
            'plantv' => Yii::t('app', 'Plantv'),
            'financiacion' => Yii::t('app', 'Financiacion'),
            'obligatorio' => Yii::t('app', 'Obligatorio'),
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
        return $this->hasOne(Financiacion::className(), ['empresa' => 'empresa', 'financiacion' => 'financiacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa1()
    {
        return $this->hasOne(Plan::className(), ['empresa' => 'empresa', 'plan' => 'plantv']);
    }
}

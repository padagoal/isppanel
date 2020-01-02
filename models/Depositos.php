<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "depositos".
 *
 * @property string $cuenta
 * @property string $numero
 * @property string $monto
 * @property string $fecha
 * @property bool $verificado
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 *
 * @property Bancos $cuenta0
 */
class Depositos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'depositos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cuenta', 'numero', 'created_at', 'modified_at'], 'required'],
            [['numero', 'monto'], 'number'],
            [['fecha', 'created_at', 'modified_at'], 'safe'],
            [['verificado'], 'boolean'],
            [['cuenta', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['cuenta', 'numero'], 'unique', 'targetAttribute' => ['cuenta', 'numero']],
            [['cuenta'], 'exist', 'skipOnError' => true, 'targetClass' => Bancos::className(), 'targetAttribute' => ['cuenta' => 'cuenta']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cuenta' => Yii::t('app', 'Cuenta'),
            'numero' => Yii::t('app', 'Numero'),
            'monto' => Yii::t('app', 'Monto'),
            'fecha' => Yii::t('app', 'Fecha'),
            'verificado' => Yii::t('app', 'Verificado'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCuenta0()
    {
        return $this->hasOne(Bancos::className(), ['cuenta' => 'cuenta']);
    }
}

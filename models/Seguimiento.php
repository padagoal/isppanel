<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seguimiento".
 *
 * @property int $seguimientoid
 * @property string $empresa
 * @property string $clienteid ID Cliente
 * @property int $vendedor
 * @property string $fecha
 * @property string $seguimiento
 * @property string $comentario
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 *
 * @property Clientes $empresa0
 * @property Tiposeguimiento $seguimiento0
 */
class Seguimiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seguimiento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'clienteid', 'created_by'], 'required'],
            [['vendedor'], 'default', 'value' => null],
            [['vendedor'], 'integer'],
            [['fecha', 'created_at', 'modified_at'], 'safe'],
            [['empresa', 'clienteid', 'comentario', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['seguimiento'], 'string', 'max' => 20],
            [['empresa', 'clienteid'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['empresa' => 'empresa', 'clienteid' => 'clienteid']],
            [['seguimiento'], 'exist', 'skipOnError' => true, 'targetClass' => Tiposeguimiento::className(), 'targetAttribute' => ['seguimiento' => 'seguimiento']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'seguimientoid' => Yii::t('app', 'Seguimientoid'),
            'empresa' => Yii::t('app', 'Empresa'),
            'clienteid' => Yii::t('app', 'Clienteid'),
            'vendedor' => Yii::t('app', 'Vendedor'),
            'fecha' => Yii::t('app', 'Fecha'),
            'seguimiento' => Yii::t('app', 'Seguimiento'),
            'comentario' => Yii::t('app', 'Comentario'),
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
        return $this->hasOne(Clientes::className(), ['empresa' => 'empresa', 'clienteid' => 'clienteid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeguimiento0()
    {
        return $this->hasOne(Tiposeguimiento::className(), ['seguimiento' => 'seguimiento']);
    }
}

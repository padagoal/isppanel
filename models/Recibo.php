<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recibo".
 *
 * @property int $numerorecibo
 * @property string $empresa
 * @property string $numero
 * @property string $clienteid
 * @property string $estadopago
 * @property int $cobrador
 * @property string $fechaemision
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 *
 * @property Clientes $empresa0
 * @property Estadopagos $estadopago0
 * @property Recibodetalle[] $recibodetalles
 */
class Recibo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recibo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'numero', 'created_at', 'modified_at'], 'required'],
            [['numero'], 'number'],
            [['cobrador'], 'default', 'value' => null],
            [['cobrador'], 'integer'],
            [['fechaemision', 'created_at', 'modified_at'], 'safe'],
            [['empresa', 'clienteid', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['estadopago'], 'string', 'max' => 20],
            [['numero', 'empresa'], 'unique', 'targetAttribute' => ['numero', 'empresa']],
            [['empresa', 'clienteid'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['empresa' => 'empresa', 'clienteid' => 'clienteid']],
            [['estadopago'], 'exist', 'skipOnError' => true, 'targetClass' => Estadopagos::className(), 'targetAttribute' => ['estadopago' => 'estadopago']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'numerorecibo' => Yii::t('app', 'Numerorecibo'),
            'empresa' => Yii::t('app', 'Empresa'),
            'numero' => Yii::t('app', 'Numero'),
            'clienteid' => Yii::t('app', 'Clienteid'),
            'estadopago' => Yii::t('app', 'Estadopago'),
            'cobrador' => Yii::t('app', 'Cobrador'),
            'fechaemision' => Yii::t('app', 'Fechaemision'),
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
    public function getEstadopago0()
    {
        return $this->hasOne(Estadopagos::className(), ['estadopago' => 'estadopago']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecibodetalles()
    {
        return $this->hasMany(Recibodetalle::className(), ['numerorecibo' => 'numerorecibo']);
    }
}

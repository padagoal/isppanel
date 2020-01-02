<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "zonas".
 *
 * @property string $zona
 * @property string $empresa
 *
 * @property Clientes[] $clientes
 * @property Empresas $empresa0
 */
class Zonas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zonas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zona', 'empresa'], 'required'],
            [['zona', 'empresa'], 'string', 'max' => 100],
            [['zona'], 'unique'],
            [['empresa'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa' => 'empresa']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'zona' => Yii::t('app', 'Zona'),
            'empresa' => Yii::t('app', 'Empresa'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Clientes::className(), ['zona' => 'zona']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa0()
    {
        return $this->hasOne(Empresas::className(), ['empresa' => 'empresa']);
    }
}

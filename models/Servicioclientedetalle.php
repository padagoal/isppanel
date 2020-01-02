<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "servicioclientedetalle".
 *
 * @property string $empresa
 * @property string $producto
 * @property string $contrato
 * @property string $tiposervicio
 * @property string $fechasolicitud
 *
 * @property Producto $empresa0
 * @property Serviciocliente $empresa1
 */
class Servicioclientedetalle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servicioclientedetalle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'producto', 'contrato', 'tiposervicio', 'fechasolicitud'], 'required'],
            [['fechasolicitud'], 'safe'],
            [['empresa', 'producto', 'contrato', 'tiposervicio'], 'string', 'max' => 100],
            [['empresa', 'producto', 'contrato', 'tiposervicio', 'fechasolicitud'], 'unique', 'targetAttribute' => ['empresa', 'producto', 'contrato', 'tiposervicio', 'fechasolicitud']],
            [['empresa', 'producto'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['empresa' => 'empresa', 'producto' => 'producto']],
            [['empresa', 'contrato', 'tiposervicio', 'fechasolicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Serviciocliente::className(), 'targetAttribute' => ['empresa' => 'empresa', 'contrato' => 'contrato', 'tiposervicio' => 'tiposervicio', 'fechasolicitud' => 'fechasolicitud']],
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
            'contrato' => Yii::t('app', 'Contrato'),
            'tiposervicio' => Yii::t('app', 'Tiposervicio'),
            'fechasolicitud' => Yii::t('app', 'Fechasolicitud'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa0()
    {
        return $this->hasOne(Producto::className(), ['empresa' => 'empresa', 'producto' => 'producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa1()
    {
        return $this->hasOne(Serviciocliente::className(), ['empresa' => 'empresa', 'contrato' => 'contrato', 'tiposervicio' => 'tiposervicio', 'fechasolicitud' => 'fechasolicitud']);
    }
}

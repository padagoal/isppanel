<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "servicios".
 *
 * @property string $empresa
 * @property string $servicio
 * @property string $monto
 * @property string $maximomensual
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 *
 * @property Serviciocliente[] $servicioclientes
 * @property Empresas $empresa0
 */
class Servicios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servicios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'servicio', 'created_by'], 'required'],
            [['monto', 'maximomensual'], 'number'],
            [['created_at', 'modified_at'], 'safe'],
            [['empresa', 'servicio', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['empresa', 'servicio'], 'unique', 'targetAttribute' => ['empresa', 'servicio']],
            [['empresa'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa' => 'empresa']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'empresa' => Yii::t('app', 'Empresa'),
            'servicio' => Yii::t('app', 'Servicio'),
            'monto' => Yii::t('app', 'Monto'),
            'maximomensual' => Yii::t('app', 'Maximomensual'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicioclientes()
    {
        return $this->hasMany(Serviciocliente::className(), ['empresa' => 'empresa', 'servicio' => 'servicio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa0()
    {
        return $this->hasOne(Empresas::className(), ['empresa' => 'empresa']);
    }
}

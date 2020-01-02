<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "promodisponible".
 *
 * @property string $empresa
 * @property string $plan
 * @property string $promocion
 *
 * @property Plan $empresa0
 * @property Promocion $empresa1
 */
class Promodisponible extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promodisponible';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'plan', 'promocion'], 'required'],
            [['empresa', 'plan', 'promocion'], 'string', 'max' => 100],
            [['empresa', 'plan', 'promocion'], 'unique', 'targetAttribute' => ['empresa', 'plan', 'promocion']],
            [['empresa', 'plan'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['empresa' => 'empresa', 'plan' => 'plan']],
            [['empresa', 'promocion'], 'exist', 'skipOnError' => true, 'targetClass' => Promocion::className(), 'targetAttribute' => ['empresa' => 'empresa', 'promocion' => 'promocion']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'empresa' => Yii::t('app', 'Empresa'),
            'plan' => Yii::t('app', 'Plan'),
            'promocion' => Yii::t('app', 'Promocion'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa0()
    {
        return $this->hasOne(Plan::className(), ['empresa' => 'empresa', 'plan' => 'plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa1()
    {
        return $this->hasOne(Promocion::className(), ['empresa' => 'empresa', 'promocion' => 'promocion']);
    }
}

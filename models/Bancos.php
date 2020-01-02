<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bancos".
 *
 * @property string $cuenta
 * @property string $banco
 *
 * @property Depositos[] $depositos
 */
class Bancos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bancos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cuenta'], 'required'],
            [['cuenta', 'banco'], 'string', 'max' => 100],
            [['cuenta'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cuenta' => Yii::t('app', 'Cuenta'),
            'banco' => Yii::t('app', 'Banco'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepositos()
    {
        return $this->hasMany(Depositos::className(), ['cuenta' => 'cuenta']);
    }
}

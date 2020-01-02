<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "olt".
 *
 * @property string $oltid
 * @property string $empresa
 * @property string $nombre
 *
 * @property Empresas $empresa0
 * @property Onus[] $onuses
 */
class Olt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'olt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['oltid'], 'required'],
            [['oltid'], 'number'],
            [['empresa', 'nombre'], 'string', 'max' => 100],
            [['oltid'], 'unique'],
            [['empresa'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa' => 'empresa']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'oltid' => Yii::t('app', 'Oltid'),
            'empresa' => Yii::t('app', 'Empresa'),
            'nombre' => Yii::t('app', 'Nombre'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa0()
    {
        return $this->hasOne(Empresas::className(), ['empresa' => 'empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnuses()
    {
        return $this->hasMany(Onus::className(), ['oltid' => 'oltid']);
    }
}

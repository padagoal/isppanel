<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "modalidades".
 *
 * @property string $modalidad
 *
 * @property Contrato[] $contratos
 */
class Modalidades extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'modalidades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['modalidad'], 'required'],
            [['modalidad'], 'string', 'max' => 20],
            [['modalidad'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'modalidad' => Yii::t('app', 'Modalidad'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratos()
    {
        return $this->hasMany(Contrato::className(), ['modalidad' => 'modalidad']);
    }
}

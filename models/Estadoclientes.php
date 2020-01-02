<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estadoclientes".
 *
 * @property string $estado
 *
 * @property Clientes[] $clientes
 */
class Estadoclientes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadoclientes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado'], 'required'],
            [['estado'], 'string', 'max' => 20],
            [['estado'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'estado' => Yii::t('app', 'Estado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Clientes::className(), ['estado' => 'estado']);
    }
}

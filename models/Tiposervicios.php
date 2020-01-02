<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tiposervicios".
 *
 * @property string $tiposervicio
 *
 * @property Serviciocliente[] $servicioclientes
 */
class Tiposervicios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tiposervicios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tiposervicio'], 'required'],
            [['tiposervicio'], 'string', 'max' => 100],
            [['tiposervicio'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tiposervicio' => Yii::t('app', 'Tiposervicio'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicioclientes()
    {
        return $this->hasMany(Serviciocliente::className(), ['tiposervicio' => 'tiposervicio']);
    }
}

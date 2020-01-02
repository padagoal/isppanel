<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tiposeguimiento".
 *
 * @property string $seguimiento
 *
 * @property Seguimiento[] $seguimientos
 */
class Tiposeguimiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tiposeguimiento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['seguimiento'], 'required'],
            [['seguimiento'], 'string', 'max' => 20],
            [['seguimiento'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'seguimiento' => Yii::t('app', 'Seguimiento'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeguimientos()
    {
        return $this->hasMany(Seguimiento::className(), ['seguimiento' => 'seguimiento']);
    }
}

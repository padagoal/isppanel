<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estadofinanciacion".
 *
 * @property string $estado
 *
 * @property Financiacion[] $financiacions
 */
class Estadofinanciacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadofinanciacion';
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
    public function getFinanciacions()
    {
        return $this->hasMany(Financiacion::className(), ['estado' => 'estado']);
    }
}

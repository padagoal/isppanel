<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "formasdescuento".
 *
 * @property string $formadescuento
 *
 * @property Promociondetalle[] $promociondetalles
 */
class Formasdescuento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'formasdescuento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['formadescuento'], 'required'],
            [['formadescuento'], 'string', 'max' => 30],
            [['formadescuento'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'formadescuento' => Yii::t('app', 'Formadescuento'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromociondetalles()
    {
        return $this->hasMany(Promociondetalle::className(), ['formadescuento' => 'formadescuento']);
    }
}

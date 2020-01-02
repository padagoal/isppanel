<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "formasduracion".
 *
 * @property string $formaduracion
 *
 * @property Plan[] $plans
 */
class Formasduracion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'formasduracion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['formaduracion'], 'required'],
            [['formaduracion'], 'string', 'max' => 30],
            [['formaduracion'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'formaduracion' => Yii::t('app', 'Formaduracion'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlans()
    {
        return $this->hasMany(Plan::className(), ['formaduracion' => 'formaduracion']);
    }
}

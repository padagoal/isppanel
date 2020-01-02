<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estadoplan".
 *
 * @property string $estado
 *
 * @property Plan[] $plans
 */
class Estadoplan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadoplan';
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
    public function getPlans()
    {
        return $this->hasMany(Plan::className(), ['estado' => 'estado']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estadostb".
 *
 * @property string $estado
 *
 * @property Settopboxes[] $settopboxes
 */
class Estadostb extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadostb';
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
    public function getSettopboxes()
    {
        return $this->hasMany(Settopboxes::className(), ['estado' => 'estado']);
    }
}

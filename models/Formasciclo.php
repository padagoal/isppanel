<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "formasciclo".
 *
 * @property string $formaciclo
 *
 * @property Producto[] $productos
 */
class Formasciclo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'formasciclo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['formaciclo'], 'required'],
            [['formaciclo'], 'string', 'max' => 100],
            [['formaciclo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'formaciclo' => Yii::t('app', 'Formaciclo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Producto::className(), ['formaciclo' => 'formaciclo']);
    }
}

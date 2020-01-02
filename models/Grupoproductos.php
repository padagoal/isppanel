<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grupoproductos".
 *
 * @property string $grupo
 * @property string $maximo
 * @property bool $servicio
 *
 * @property Producto[] $productos
 */
class Grupoproductos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grupoproductos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grupo'], 'required'],
            [['maximo'], 'number'],
            [['servicio'], 'boolean'],
            [['grupo'], 'string', 'max' => 20],
            [['grupo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'grupo' => Yii::t('app', 'Grupo'),
            'maximo' => Yii::t('app', 'Maximo'),
            'servicio' => Yii::t('app', 'Servicio'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Producto::className(), ['grupo' => 'grupo']);
    }
}

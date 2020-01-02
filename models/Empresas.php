<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empresas".
 *
 * @property string $empresa
 * @property string $pais
 * @property string $lenguaje
 *
 * @property Clientes[] $clientes
 * @property Financiacion[] $financiacions
 * @property Olt[] $olts
 * @property Onus[] $onuses
 * @property Producto[] $productos
 * @property Servicios[] $servicios
 * @property Settopboxes[] $settopboxes
 * @property User[] $users
 * @property Zonas[] $zonas
 */
class Empresas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'empresas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'pais'], 'required'],
            [['empresa', 'pais'], 'string', 'max' => 100],
            [['lenguaje'], 'string', 'max' => 20],
            [['empresa'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'empresa' => Yii::t('app', 'Empresa'),
            'pais' => Yii::t('app', 'Pais'),
            'lenguaje' => Yii::t('app', 'Lenguaje'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Clientes::className(), ['empresa' => 'empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanciacions()
    {
        return $this->hasMany(Financiacion::className(), ['empresa' => 'empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOlts()
    {
        return $this->hasMany(Olt::className(), ['empresa' => 'empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnuses()
    {
        return $this->hasMany(Onus::className(), ['empresa' => 'empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Producto::className(), ['empresa' => 'empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicios()
    {
        return $this->hasMany(Servicios::className(), ['empresa' => 'empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettopboxes()
    {
        return $this->hasMany(Settopboxes::className(), ['empresa' => 'empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['empresa' => 'empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZonas()
    {
        return $this->hasMany(Zonas::className(), ['empresa' => 'empresa']);
    }
}

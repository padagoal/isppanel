<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "autorizacion".
 *
 * @property string $modelo
 * @property string $accion
 * @property string $profile
 */
class Autorizacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'autorizacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['modelo', 'accion', 'profile'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'modelo' => Yii::t('app', 'Modelo'),
            'accion' => Yii::t('app', 'Accion'),
            'profile' => Yii::t('app', 'Profile'),
        ];
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recibodetalle".
 *
 * @property int $numerorecibo
 * @property int $estadocuentaid
 * @property string $empresa
 * @property string $clienteid
 * @property string $periodo
 * @property string $tipopago
 * @property string $monto
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 *
 * @property Recibo $numerorecibo0
 */
class Recibodetalle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recibodetalle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['numerorecibo', 'estadocuentaid', 'empresa', 'clienteid', 'periodo', 'tipopago', 'monto', 'created_by'], 'required'],
            [['numerorecibo', 'estadocuentaid'], 'default', 'value' => null],
            [['numerorecibo', 'estadocuentaid'], 'integer'],
            [['monto'], 'number'],
            [['created_at', 'modified_at'], 'safe'],
            [['empresa', 'clienteid', 'tipopago', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['periodo'], 'string', 'max' => 10],
            [['numerorecibo', 'estadocuentaid', 'empresa', 'clienteid', 'periodo', 'tipopago'], 'unique', 'targetAttribute' => ['numerorecibo', 'estadocuentaid', 'empresa', 'clienteid', 'periodo', 'tipopago']],
            [['numerorecibo'], 'exist', 'skipOnError' => true, 'targetClass' => Recibo::className(), 'targetAttribute' => ['numerorecibo' => 'numerorecibo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'numerorecibo' => Yii::t('app', 'Numerorecibo'),
            'estadocuentaid' => Yii::t('app', 'Estadocuentaid'),
            'empresa' => Yii::t('app', 'Empresa'),
            'clienteid' => Yii::t('app', 'Clienteid'),
            'periodo' => Yii::t('app', 'Periodo'),
            'tipopago' => Yii::t('app', 'Tipopago'),
            'monto' => Yii::t('app', 'Monto'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNumerorecibo0()
    {
        return $this->hasOne(Recibo::className(), ['numerorecibo' => 'numerorecibo']);
    }
}

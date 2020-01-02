<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "settopboxes".
 *
 * @property string $stbid
 * @property string $empresa
 * @property string $estado
 * @property string $contrato
 * @property string $cardid
 * @property string $fechainstalacion
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 *
 * @property Contrato $empresa0
 * @property Empresas $empresa1
 * @property Estadostb $estado0
 */
class Settopboxes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'settopboxes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stbid', 'created_by'], 'required'],
            [['fechainstalacion', 'created_at', 'modified_at'], 'safe'],
            [['stbid', 'empresa', 'contrato', 'cardid', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['estado'], 'string', 'max' => 20],
            [['stbid'], 'unique'],
            [['empresa', 'contrato'], 'exist', 'skipOnError' => true, 'targetClass' => Contrato::className(), 'targetAttribute' => ['empresa' => 'empresa', 'contrato' => 'contrato']],
            [['empresa'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa' => 'empresa']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estadostb::className(), 'targetAttribute' => ['estado' => 'estado']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'stbid' => Yii::t('app', 'Stbid'),
            'empresa' => Yii::t('app', 'Empresa'),
            'estado' => Yii::t('app', 'Estado'),
            'contrato' => Yii::t('app', 'Contrato'),
            'cardid' => Yii::t('app', 'Cardid'),
            'fechainstalacion' => Yii::t('app', 'Fechainstalacion'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa0()
    {
        return $this->hasOne(Contrato::className(), ['empresa' => 'empresa', 'contrato' => 'contrato']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa1()
    {
        return $this->hasOne(Empresas::className(), ['empresa' => 'empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estadostb::className(), ['estado' => 'estado']);
    }
}

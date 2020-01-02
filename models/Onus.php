<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "onus".
 *
 * @property string $onuid
 * @property string $oltid
 * @property string $board
 * @property string $port
 * @property string $empresa
 * @property string $contrato
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 *
 * @property Contrato $empresa0
 * @property Empresas $empresa1
 * @property Olt $olt
 */
class Onus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'onus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['onuid', 'oltid', 'board', 'port', 'created_by'], 'required'],
            [['oltid', 'board', 'port'], 'number'],
            [['created_at', 'modified_at'], 'safe'],
            [['onuid', 'empresa', 'contrato', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['onuid'], 'unique'],
            [['empresa', 'contrato'], 'exist', 'skipOnError' => true, 'targetClass' => Contrato::className(), 'targetAttribute' => ['empresa' => 'empresa', 'contrato' => 'contrato']],
            [['empresa'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa' => 'empresa']],
            [['oltid'], 'exist', 'skipOnError' => true, 'targetClass' => Olt::className(), 'targetAttribute' => ['oltid' => 'oltid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'onuid' => Yii::t('app', 'Onuid'),
            'oltid' => Yii::t('app', 'Oltid'),
            'board' => Yii::t('app', 'Board'),
            'port' => Yii::t('app', 'Port'),
            'empresa' => Yii::t('app', 'Empresa'),
            'contrato' => Yii::t('app', 'Contrato'),
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
    public function getOlt()
    {
        return $this->hasOne(Olt::className(), ['oltid' => 'oltid']);
    }
}

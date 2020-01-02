<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "promocion".
 *
 * @property string $empresa
 * @property string $promocion
 * @property string $estado
 * @property string $fechadesde
 * @property string $fechahasta
 * @property string $observaciones
 * @property bool $interno
 * @property string $orden
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 *
 * @property Contrato[] $contratos
 * @property Estadopromos $estado0
 * @property Promociondetalle[] $promociondetalles
 * @property Plandetalle[] $empresas
 * @property Promodisponible[] $promodisponibles
 * @property Plan[] $empresas0
 */
class Promocion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promocion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'promocion', 'created_by'], 'required'],
            [['fechadesde', 'fechahasta', 'created_at', 'modified_at'], 'safe'],
            [['interno'], 'boolean'],
            [['orden'], 'number'],
            [['empresa', 'promocion', 'observaciones', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['estado'], 'string', 'max' => 20],
            [['empresa', 'promocion'], 'unique', 'targetAttribute' => ['empresa', 'promocion']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estadopromos::className(), 'targetAttribute' => ['estado' => 'estado']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'empresa' => Yii::t('app', 'Empresa'),
            'promocion' => Yii::t('app', 'Promocion'),
            'estado' => Yii::t('app', 'Estado'),
            'fechadesde' => Yii::t('app', 'Fechadesde'),
            'fechahasta' => Yii::t('app', 'Fechahasta'),
            'observaciones' => Yii::t('app', 'Observaciones'),
            'interno' => Yii::t('app', 'Interno'),
            'orden' => Yii::t('app', 'Orden'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratos()
    {
        return $this->hasMany(Contrato::className(), ['empresa' => 'empresa', 'promocion' => 'promocion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estadopromos::className(), ['estado' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromociondetalles()
    {
        return $this->hasMany(Promociondetalle::className(), ['empresa' => 'empresa', 'promocion' => 'promocion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas()
    {
        return $this->hasMany(Plandetalle::className(), ['empresa' => 'empresa', 'producto' => 'producto', 'plan' => 'plan'])->viaTable('promociondetalle', ['empresa' => 'empresa', 'promocion' => 'promocion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromodisponibles()
    {
        return $this->hasMany(Promodisponible::className(), ['empresa' => 'empresa', 'promocion' => 'promocion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas0()
    {
        return $this->hasMany(Plan::className(), ['empresa' => 'empresa', 'plan' => 'plan'])->viaTable('promodisponible', ['empresa' => 'empresa', 'promocion' => 'promocion']);
    }

    public function byDefault() {
        $db = Yii::$app->db;
        $query = "select promocion from promocion where empresa = :empresa and pordefecto is true";
        $rows=$db->createCommand($query)->bindValues(['empresa'=> Yii::$app->user->identity->empresa])->queryOne();
        return $rows['promocion'];
    }

}

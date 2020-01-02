<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "serviciocliente".
 *
 * @property string $empresa
 * @property string $contrato
 * @property string $tiposervicio
 * @property string $fechasolicitud
 * @property string $fecharealizacion
 * @property bool $realizado
 * @property string $callcenter
 * @property int $tecnico
 * @property string $estado
 * @property array $ubicacion
 * @property string $observaciones
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 *
 * @property Contrato $empresa0
 * @property Estadoservicios $estado0
 * @property Tiposervicios $tiposervicio0
 * @property User $tecnico0
 * @property Servicioclientedetalle[] $servicioclientedetalles
 * @property Producto[] $empresas
 */
class Serviciocliente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'serviciocliente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'contrato', 'tiposervicio', 'fechasolicitud', 'created_by'], 'required'],
            [['fechasolicitud', 'fecharealizacion', 'ubicacion', 'created_at', 'modified_at'], 'safe'],
            [['realizado'], 'boolean'],
            [['tecnico'], 'default', 'value' => null],
            [['tecnico'], 'integer'],
            [['observaciones'], 'string'],
            [['empresa', 'contrato', 'tiposervicio', 'callcenter', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['estado'], 'string', 'max' => 20],
            [['empresa', 'contrato', 'tiposervicio', 'fechasolicitud'], 'unique', 'targetAttribute' => ['empresa', 'contrato', 'tiposervicio', 'fechasolicitud']],
            [['empresa', 'contrato'], 'exist', 'skipOnError' => true, 'targetClass' => Contrato::className(), 'targetAttribute' => ['empresa' => 'empresa', 'contrato' => 'contrato']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoservicios::className(), 'targetAttribute' => ['estado' => 'estado']],
            [['tiposervicio'], 'exist', 'skipOnError' => true, 'targetClass' => Tiposervicios::className(), 'targetAttribute' => ['tiposervicio' => 'tiposervicio']],
            [['tecnico'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['tecnico' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'empresa' => Yii::t('app', 'Empresa'),
            'contrato' => Yii::t('app', 'Contrato'),
            'tiposervicio' => Yii::t('app', 'Tiposervicio'),
            'fechasolicitud' => Yii::t('app', 'Fechasolicitud'),
            'fecharealizacion' => Yii::t('app', 'Fecharealizacion'),
            'realizado' => Yii::t('app', 'Realizado'),
            'callcenter' => Yii::t('app', 'Callcenter'),
            'tecnico' => Yii::t('app', 'Tecnico'),
            'estado' => Yii::t('app', 'Estado'),
            'ubicacion' => Yii::t('app', 'Ubicacion'),
            'observaciones' => Yii::t('app', 'Observaciones'),
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
    public function getEstado0()
    {
        return $this->hasOne(Estadoservicios::className(), ['estado' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposervicio0()
    {
        return $this->hasOne(Tiposervicios::className(), ['tiposervicio' => 'tiposervicio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTecnico0()
    {
        return $this->hasOne(User::className(), ['id' => 'tecnico']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicioclientedetalles()
    {
        return $this->hasMany(Servicioclientedetalle::className(), ['empresa' => 'empresa', 'contrato' => 'contrato', 'tiposervicio' => 'tiposervicio', 'fechasolicitud' => 'fechasolicitud']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas()
    {
        return $this->hasMany(Producto::className(), ['empresa' => 'empresa', 'producto' => 'producto'])->viaTable('servicioclientedetalle', ['empresa' => 'empresa', 'contrato' => 'contrato', 'tiposervicio' => 'tiposervicio', 'fechasolicitud' => 'fechasolicitud']);
    }
}

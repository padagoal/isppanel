<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contrato".
 *
 * @property string $empresa
 * @property string $contrato
 * @property string $clienteid
 * @property int $vendedor
 * @property string $plan
 * @property string $promocion
 * @property string $financiacion
 * @property string $estado
 * @property string $fechainicio
 * @property string $fechafin
 * @property string $equipos
 * @property array $parametros Datos en Json para guardar los descuentos, items, etc.
 Aqui guardamos el plan original, la promo original, financiacion original.
 * @property string $observaciones
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 * @property string $duracion
 * @property string $diavto
 * @property string $modalidad
 *
 * @property Clientes $empresa0
 * @property Estadoventas $estado0
 * @property Financiacion $empresa1
 * @property Modalidades $modalidad0
 * @property Plan $empresa2
 * @property Promocion $empresa3
 * @property Contratodetalle[] $contratodetalles
 * @property Onus[] $onuses
 * @property Serviciocliente[] $servicioclientes
 * @property Settopboxes[] $settopboxes
 */
class Contrato extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contrato';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'contrato', 'clienteid', 'vendedor', 'equipos', 'created_by'], 'required'],
            [['vendedor'], 'default', 'value' => null],
            [['vendedor'], 'integer'],
            [['fechainicio', 'fechafin', 'parametros', 'created_at', 'modified_at','fechainstalacion'], 'safe'],
            [['equipos', 'duracion', 'diavto'], 'number'],
            [['observaciones'], 'string'],
            [['empresa', 'contrato', 'clienteid', 'plan', 'promocion', 'financiacion', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['estado', 'modalidad'], 'string', 'max' => 20],
            [['empresa', 'clienteid'], 'unique', 'targetAttribute' => ['empresa', 'clienteid']],
            [['empresa', 'contrato'], 'unique', 'targetAttribute' => ['empresa', 'contrato']],
            [['empresa', 'clienteid'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['empresa' => 'empresa', 'clienteid' => 'clienteid']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoventas::className(), 'targetAttribute' => ['estado' => 'estado']],
            [['empresa', 'financiacion'], 'exist', 'skipOnError' => true, 'targetClass' => Financiacion::className(), 'targetAttribute' => ['empresa' => 'empresa', 'financiacion' => 'financiacion']],
            [['modalidad'], 'exist', 'skipOnError' => true, 'targetClass' => Modalidades::className(), 'targetAttribute' => ['modalidad' => 'modalidad']],
            [['empresa', 'plan'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['empresa' => 'empresa', 'plan' => 'plan']],
            [['empresa', 'promocion'], 'exist', 'skipOnError' => true, 'targetClass' => Promocion::className(), 'targetAttribute' => ['empresa' => 'empresa', 'promocion' => 'promocion']],
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
            'clienteid' => Yii::t('app', 'Clienteid'),
            'vendedor' => Yii::t('app', 'Vendedor'),
            'plan' => Yii::t('app', 'Plan'),
            'promocion' => Yii::t('app', 'Promocion'),
            'financiacion' => Yii::t('app', 'Financiacion'),
            'estado' => Yii::t('app', 'Estado'),
            'fechainicio' => Yii::t('app', 'Fechainicio'),
            'fechainstalacion' => Yii::t('app', 'Fechainstalacion'),
            'fechafin' => Yii::t('app', 'Fechafin'),
            'equipos' => Yii::t('app', 'Equipos'),
            'parametros' => Yii::t('app', 'Parametros'),
            'observaciones' => Yii::t('app', 'Observaciones'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'modified_at' => Yii::t('app', 'Modified At'),
            'duracion' => Yii::t('app', 'Duracion'),
            'diavto' => Yii::t('app', 'Diavto'),
            'modalidad' => Yii::t('app', 'Modalidad'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa0()
    {
        return $this->hasOne(Clientes::className(), ['empresa' => 'empresa', 'clienteid' => 'clienteid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estadoventas::className(), ['estado' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa1()
    {
        return $this->hasOne(Financiacion::className(), ['empresa' => 'empresa', 'financiacion' => 'financiacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModalidad0()
    {
        return $this->hasOne(Modalidades::className(), ['modalidad' => 'modalidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa2()
    {
        return $this->hasOne(Plan::className(), ['empresa' => 'empresa', 'plan' => 'plan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa3()
    {
        return $this->hasOne(Promocion::className(), ['empresa' => 'empresa', 'promocion' => 'promocion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratodetalles()
    {
        return $this->hasMany(Contratodetalle::className(), ['empresa' => 'empresa', 'contrato' => 'contrato']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnuses()
    {
        return $this->hasMany(Onus::className(), ['empresa' => 'empresa', 'contrato' => 'contrato']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicioclientes()
    {
        return $this->hasMany(Serviciocliente::className(), ['empresa' => 'empresa', 'contrato' => 'contrato']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettopboxes()
    {
        return $this->hasMany(Settopboxes::className(), ['empresa' => 'empresa', 'contrato' => 'contrato']);
    }

    public function numeroContrato() {
        $db = Yii::$app->db;
        $query = "select contrato from numeradores where empresa = :empresa";
        $rows=$db->createCommand($query)->bindValues(['empresa'=> Yii::$app->user->identity->empresa])->queryOne();
        $contrato =sprintf ('%1$06d-%2$04d',$rows['contrato'], date('Y'));
        $query = "update numeradores set contrato = contrato +1 where empresa = :empresa";
        $db->createCommand($query)->bindValues(['empresa'=> Yii::$app->user->identity->empresa])->execute();
        return $contrato;
    }

    public function getNameCliente($clienteid){
        $db = Yii::$app->db;
        $query = "select cliente from clientes where clienteid = :clienteid and empresa = :empresa";
        $rows=$db->createCommand($query)->bindValues(['clienteid'=>$clienteid,'empresa'=> Yii::$app->user->identity->empresa])->queryOne();
        if(count($rows)>0){
            return $rows['cliente'];
        }else{
            return '';
        }


    }
}

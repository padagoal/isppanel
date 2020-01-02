<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clientes".
 *
 * @property string $empresa
 * @property string $clienteid ID Cliente
 * @property string $cliente
 * @property string $contrato Contrato N°
 * @property string $cedula
 * @property string $direccion
 * @property string $zona
 * @property string $celular
 * @property string $whatsapp
 * @property string $localizacion
 * @property string $lat
 * @property string $lon
 * @property string $fechainicio Fec. Inicio
 * @property string $fechacontrato Fecha Contrato
 * @property string $diadecorte Día de Corte
 * @property string $estado Estado
 * @property int $callcenter
 * @property int $vendedor
 * @property string $monto
 * @property string $nir
 * @property string $ccc
 * @property string $observaciones
 * @property bool $pordefecto
 * @property bool $interno
 * @property string $orden
 * @property string $created_by
 * @property string $created_at
 * @property string $modified_by
 * @property string $modified_at
 *
 * @property Empresas $empresa0
 * @property Estadoclientes $estado0
 * @property Zonas $zona0
 * @property Contrato $contrato0
 * @property Factura[] $facturas
 * @property Recibo[] $recibos
 * @property Seguimiento[] $seguimientos
 */
class Clientes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clientes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'clienteid', 'cliente', 'created_by'], 'required'],
            [['fechainicio', 'fechacontrato', 'created_at', 'modified_at'], 'safe'],
            [['diadecorte', 'monto', 'orden'], 'number'],
            [['callcenter', 'vendedor'], 'default', 'value' => null],
            [['callcenter', 'vendedor'], 'integer'],
            [['observaciones'], 'string'],
            [['pordefecto', 'interno'], 'boolean'],
            [['empresa', 'clienteid', 'cliente', 'contrato', 'cedula', 'direccion', 'zona', 'celular', 'whatsapp', 'lat', 'lon', 'nir', 'ccc', 'created_by', 'modified_by'], 'string', 'max' => 100],
            [['localizacion'], 'string', 'max' => 1000],
            [['estado'], 'string', 'max' => 20],
            [['empresa', 'clienteid'], 'unique', 'targetAttribute' => ['empresa', 'clienteid']],
            [['empresa'], 'exist', 'skipOnError' => true, 'targetClass' => Empresas::className(), 'targetAttribute' => ['empresa' => 'empresa']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoclientes::className(), 'targetAttribute' => ['estado' => 'estado']],
            [['zona'], 'exist', 'skipOnError' => true, 'targetClass' => Zonas::className(), 'targetAttribute' => ['zona' => 'zona']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'empresa' => Yii::t('app', 'Empresa'),
            'clienteid' => Yii::t('app', 'Clienteid'),
            'cliente' => Yii::t('app', 'Cliente'),
            'contrato' => Yii::t('app', 'Contrato'),
            'cedula' => Yii::t('app', 'Cedula'),
            'direccion' => Yii::t('app', 'Direccion'),
            'zona' => Yii::t('app', 'Zona'),
            'celular' => Yii::t('app', 'Celular'),
            'whatsapp' => Yii::t('app', 'Whatsapp'),
            'localizacion' => Yii::t('app', 'Localizacion'),
            'lat' => Yii::t('app', 'Lat'),
            'lon' => Yii::t('app', 'Lon'),
            'fechainicio' => Yii::t('app', 'Fechainicio'),
            'fechacontrato' => Yii::t('app', 'Fechacontrato'),
            'diadecorte' => Yii::t('app', 'Diadecorte'),
            'estado' => Yii::t('app', 'Estado'),
            'callcenter' => Yii::t('app', 'Callcenter'),
            'vendedor' => Yii::t('app', 'Vendedor'),
            'monto' => Yii::t('app', 'Monto'),
            'nir' => Yii::t('app', 'Nir'),
            'ccc' => Yii::t('app', 'Ccc'),
            'observaciones' => Yii::t('app', 'Observaciones'),
            'pordefecto' => Yii::t('app', 'Pordefecto'),
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
    public function getEmpresa0()
    {
        return $this->hasOne(Empresas::className(), ['empresa' => 'empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estadoclientes::className(), ['estado' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZona0()
    {
        return $this->hasOne(Zonas::className(), ['zona' => 'zona']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContrato0()
    {
        return $this->hasOne(Contrato::className(), ['empresa' => 'empresa', 'clienteid' => 'clienteid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturas()
    {
        return $this->hasMany(Factura::className(), ['empresa' => 'empresa', 'clienteid' => 'clienteid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecibos()
    {
        return $this->hasMany(Recibo::className(), ['empresa' => 'empresa', 'clienteid' => 'clienteid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeguimientos()
    {
        return $this->hasMany(Seguimiento::className(), ['empresa' => 'empresa', 'clienteid' => 'clienteid']);
    }

    public function nombreUsuario($id) {
        if (empty($id)) return 'Sin Vendedor';
        $db = Yii::$app->db;
        $query = "select username from  \"user\" where id = :id and empresa = :empresa";
        $cmd=$db->createCommand($query)->bindValues(['id'=>$id,'empresa'=> Yii::$app->user->identity->empresa]);
        $rows = $cmd->queryOne();
        return $rows['username'];
    }
}

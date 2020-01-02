<?php

namespace app\controllers;

use Yii;
use yii\base\ErrorException;
use app\models\Recibo;
use app\models\ReciboBuscar;
use yii\web\Controller;
use app\models\Recibodetalle;
use app\models\RecibodetalleBuscar;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;
use app\models\Authmanager;
use app\models\Tools;
use yii\helpers\Inflector;

/**
 * ReciboController implements the CRUD actions for Recibo model.
 */
class ReciboController extends Controller
{
    /**
     * @inheritdoc
     */
	private $title = "";
    private $titleplural = "";	 
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }
	public function beforeAction($action)
    {
        $this->title = ucfirst($this->id);
        $this->titleplural = Inflector::pluralize(Inflector::camel2words(ucfirst($this->id)));
        if (Yii::$app->user->isGuest) {
            $this->redirect(['/user/login']);
            return false;
        }
        if(AuthManager::Verify($this->id,$this->action->id,Yii::$app->user->identity->id)) {
            return true;
        } else {
            $this->redirect(['/']);
            return false;
        };
    }
    /**
     * Lists all Recibo models.
     * @return mixed
     */
    public function actionIndex()
    {    
               
		$searchModel = new ReciboBuscar();
		$searchModel->empresa = Yii::$app->user->identity->empresa;
		$extraparams = null; //$extraparams['key'] = 'value';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$extraparams);

        return $this->render('index', [
		    'title' => $this->titleplural,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Recibo model.
     * @param integer $numerorecibo
     * @return mixed
     */
    public function actionView($numerorecibo)
    {   
        $request = Yii::$app->request; 		
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> Yii::t('app',$this->title)."# ".$numerorecibo,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($numerorecibo),
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a(Yii::t('app','Edit'),['update','numerorecibo'=>$numerorecibo],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($numerorecibo),
            ]);
        }
    }

    /**
     * Creates a new Recibo model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;   		
        $model = new Recibo();
		$model->empresa = Yii::$app->user->identity->empresa;
		if ($model->hasProperty('created_by')) {
            $model->created_at = date('d-m-Y');
            $model->modified_at = date('d-m-Y');
            $model->created_by = Yii::$app->user->identity->username;
        }
		if(isset($_GET['_pjax']) && !empty($_GET['_pjax'])) {
			return;
		}		
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;			
            if($request->isGet){
                return [
                    'title'=> Yii::t('app', "Add")." ".Yii::t('app', $this->title), 
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button( Yii::t('app', 'Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button( Yii::t('app', 'Save'),['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> Yii::t('app', "Add")." ".Yii::t('app', $this->title), 
                    'content'=>'<span class="text-success">Crear Recibo realizado</span>',
                    'footer'=> Html::button(Yii::t('app', 'Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a(Yii::t('app', 'Create More'),['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> Yii::t('app', "Add")." ".Yii::t('app', $this->title),
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button(Yii::t('app','Cerrar'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                               Html::button(Yii::t('app','Guardar'),['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['updatemd', 'numerorecibo' => $model->numerorecibo]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    public function nextNumeroRecibo(){
        $db = Yii::$app->db;
        $query = "select NEXTVAL('recibo_numerorecibo_seq') as next;";
        $cmd=$db->createCommand($query);
        $aux = $cmd->queryOne();
        $numero  = $aux['next'];
        return $numero;
    }


    public function actionGeneratemonths(){
        $datos = $_POST['asset'];
        $clienteid =$datos['clienteid'];
        $contrato =$datos['contrato'];
        $empresa = $datos['empresa'];
        $cantidadMesesAPagar =$datos['cantMeses'];
        $estadosid="";
        $db = Yii::$app->db;

        $query = <<<EOF
                select estadocuentaid,contrato,producto,estadopago,tipopago,vencimiento,monto,numerocuota from estadocuenta where
            contrato = :contrato and empresa = :empresa and (estadopago='Pendiente' or estadopago='Vencido')
        order by vencimiento;
EOF;

        $cmd=$db->createCommand($query)->bindValues(['contrato'=>$contrato,'empresa'=>$empresa]);
        $rows = $cmd->queryAll();
        try{

            if(count($rows)>0){

                return self::panelParaPagar($rows,$cantidadMesesAPagar,true);
                //return '<h2>Hay datos</h2>';
            }else{
                return '<h2>No existe Cuotas Pendientes o Vencidads para el Contrato - First Attemp</h2>';
            }

        } catch (\Exception $e) {
            print_r( $e->getMessage(). "\n");
            return 'Excepción capturada: '.  $e->getMessage(). "\n";
        }

    }


    function panelParaPagar($params,$cantidadMesesAPagar,$existeCuota)
    {
        $cols = "";
        $montototalapagar = 0;
        $montototalMes = 0;
        $estadosid='';

        if ($existeCuota) {
            $numeroCuotaActual = $params[0]['numerocuota'];
            $i = 0;
          // print_r("\n".'Aqui'."\n");
          //  print_r("\n".'numerocuotaactual = '.$numeroCuotaActual."\n");
          //  print_r("\n".'$cantidadMesesAPagar = '.$cantidadMesesAPagar."\n");
            foreach ($params as $filadato) {
                if ($cantidadMesesAPagar > $i) {
                    if ($filadato['numerocuota'] != $numeroCuotaActual) {
                        $aux = self::getRowBottom($montototalMes,$numeroCuotaActual);
                        $cols .= $aux;
                        $montototalMes = 0;
                        $numeroCuotaActual = $filadato['numerocuota'];
                        $i++;
                    }
                    if ($cantidadMesesAPagar > $i) {
                        //print_r("\n".'HERE'."\n");
                        $montototalapagar += $filadato['monto'];
                        $montototalMes += $filadato['monto'];
                        $aux = self::getRowDetail($filadato);
                        $cols .= $aux;

                        $estadosid .= "".$filadato['estadocuentaid']." ,";

                    }

                } else {
                    return self::generarPanelParaPago($cols,$montototalapagar,$estadosid,$existeCuota);
                }
            }
            return self::generarPanelParaPago($cols,$montototalapagar,$estadosid,$existeCuota);
        }else{
            return self::generarPanelParaPago($cols,$montototalapagar,$estadosid,$existeCuota);
        }

    }

    function generarPanelParaPago($cols,$totalMes,$estadosid,$existeCuota){
        $mensaje='';
        $cabecera ='';
        if(!$existeCuota){

            $mensaje = '<tr data-key="estadopre" class="bg-success"> ';
            $mensaje .= '<td data-col-seq="0" colspan="4"><center>No existen cargos pendientes de Pago</center></td>';
            $mensaje .= '</tr>';
            $cabecera = '';
        }else{
            $cabecera = <<<EOF

<tr class="bg-info">
    <th data-col-seq="0" style="width: 10%;" colspan="1"><h3>Total a Pagar:</h3></th>
    <th data-col-seq="1" style="width: 40%;" colspan="1"><center><h3>$totalMes Gs.</h3></center> </th>
    <th data-col-seq="1" style="width: 20%;" colspan="2"><center><input type="button" class="btn btn-success" id="paidMonths"  
    name="paidMonths" value="Pagar Cuotas" title="$estadosid" onclick="testeP();"></center></th>
</tr>
EOF;
        }


        $panel = <<< EOF
<div id="crud-datatable-estadocuenta" class="grid-view hide-resize" data-krajee-grid="kvGridInit_ebe0c92c">
<div class="panel panel-primary">
    <div class="panel-heading">    <div class="pull-right">
        <div class="summary"></div>
    </div>
    <h3 class="panel-title">
        <i class="glyphicon glyphicon-list"></i> Meses a Pagar
    </h3>
    <div class="clearfix"></div></div>
    <div class="kv-panel-before"> 
       <div class="btn-toolbar kv-grid-toolbar toolbar-container pull-right">    
    <div class="clearfix"></div></div>
   
    </div>
    <div id="crud-datatable-estadocuenta-container" class="table-responsive kv-grid-container">
        <table class="kv-grid-table table table-bordered table-condensed kv-table-wrap"><colgroup><col><col><col class="skip-export"></colgroup>
<thead>

$cabecera

<tr>
    <th data-col-seq="0" style="width: 10%;">Mes Cuota</th>
    <th data-col-seq="1" style="width: 40%;">Producto</th>
    <th data-col-seq="1" style="width: 20%;">Estado Pago</th>
    <th data-col-seq="1" style="width: 30%;">Monto</th>
</tr>

</thead>
<tbody> 
$mensaje
$cols

</tbody>
</table></div>
    <div class="kv-panel-after"></div>    
</div></div>
EOF;
        return $panel;
    }

    function getRowDetail($row) {

        $res = '<tr data-key="estadocuenta"> ';
        $res .= '<td data-col-seq="0">'.$row['numerocuota'].'</td>';
        $res .= '<td data-col-seq="1">'.$row['producto'].'</td>';
        $res .= '<td data-col-seq="2">'.$row['estadopago'].'</td>';
        $res .= '<td data-col-seq="3">'.$row['monto'].' Gs.</td>';
        $res .= '</tr>';
        return $res;
    }

    function getRowBottom($totalMes,$numerocuota) {
        $res = ' <tr data-key="estadocuenta" class="bg-danger"> ';
        $res .= '<td data-col-seq="0" colspan="2">'.'<center>'.'Total Mes #'.$numerocuota.'</td>'.'</center>';
        $res .= '<td data-col-seq="1" colspan="2">'.$totalMes.' Gs.</td>';
        $res .= '</tr>';
        return $res;
    }

    public function actionPaidmonthsselected(){
        $datos = $_POST["paidM"];

        $clienteid =$datos['clienteid'];
        $contrato =$datos['contrato'];
        $empresa = $datos['empresa'];
        $estadoid = explode(',',$datos['estados']);

        $db = Yii::$app->db;
        try{
            $i=0;

        foreach ($estadoid as $fila){
            if($fila != '' and $fila != 0 ){


            $query = <<<EOF
    update estadocuenta set estadopago = 'Pagado' where estadocuentaid = :estadocuentaid;
EOF;
            $cmd=$db->createCommand($query)->bindValues(['estadocuentaid'=>$fila]);
            $cmd->execute();

            }
        }
            $infoclientecontrato =  Tools::getEstadoContratoCliente($contrato,$clienteid,$empresa);
            if( ($infoclientecontrato['conestado']== 'Venta' || $infoclientecontrato['conestado']== 'Preinstalacion')){
                Tools::cambioEstadoContratoCliente($empresa,$contrato,'Instalacion',$clienteid);
            }

            return self::generarReciboConPago($datos['clienteid'],$datos['numero'],$datos['empresa'],$datos['cobrador'],
                $datos['fechaemision'],$estadoid,true);
        }catch (\Exception $e) {
            print_r( $e->getMessage(). "\n");
            return 'Excepción capturada PAIDMONTH: '.  $e->getMessage(). "\n";
        }


    }



    public function datosParaPagarPreinstalacion($empresa,$clienteid,$contrato){

        $existePreinstalacion = false;

        $aux = Tools::hasPreinstalacion($contrato,$empresa);
        if($aux['estadopago'] == 'Pendiente' && $aux['monto']>0){
            $existePreinstalacion = true;
        }

        if($existePreinstalacion){

            return self::panelPre($aux,true);
        }else{
            return self::panelPre($aux,false);
        }


    }


    public function actionPaidpre(){
        $datos = $_POST["info"];
        $db = Yii::$app->db;
        $query = <<<EOF
select estadocuentaid,estadopago,monto,grupoproducto,contrato
from estadocuenta
where contrato = :contrato and empresa = :empresa and (grupoproducto = 'Preinstalacion' or subgrupoproducto = 'Preinstalacion')
group by estadopago,grupoproducto,estadocuentaid;
        
EOF;

        $cmd=$db->createCommand($query)->bindValues(['contrato'=>$datos['contrato'],'empresa'=>$datos['empresa']]);
        $rows = $cmd->queryAll();

        if(count($rows)>0){
            foreach ($rows as $fila ){
                $query = <<<EOF
    update estadocuenta set estadopago = 'Pagado' where estadocuentaid = :estadocuentaid;
EOF;

                $cmd=$db->createCommand($query)->bindValues(['estadocuentaid'=>$fila['estadocuentaid']]);
                $cmd->execute();
            }
    try{
            $query = <<< EOF
        SELECT actualizar_estado_cliente_contrato(:empresa, :contrato,:estado,:clienteid);
EOF;
            //$db->createCommand($query)->bindValues(['empresa'=>$datos['empresa'],
            //    'clienteid'=>$datos['clienteid'],'estado'=>'Instalacion','contrato'=>$datos['contrato']])->execute();
            Tools::cambioEstadoContratoCliente($datos['empresa'],$datos['contrato'],'Instalacion',$datos['clienteid']);
        }catch (\Exception $e) {
            print_r( $e->getMessage(). "\n");
            return 'Excepción paidpre: '.  $e->getMessage(). "\n";
        }

        }
        return self::generarReciboConPago($datos['clienteid'],$datos['numero'],$datos['empresa'],$datos['cobrador'],
            $datos['fechaemision'],$rows,false);
    }





    function panelPre($params,$existePre) {
        $cols = "";


            $mensaje = '';

            if($existePre){
                $aux = self::getRow($params);
                $cols .= $aux;
                $mensaje = '';
            }else{

                $mensaje = '<tr data-key="estadopre" class="bg-success"> ';
                $mensaje .= '<td data-col-seq="0" colspan="3"><center>No existen cargos pendientes de Pago</center></td>';
                $mensaje .= '</tr>';
            }


        $panel = <<< EOF
<div id="crud-datatable-preinstalacion" class="grid-view hide-resize" data-krajee-grid="kvGridInit_ebe0c92c">
<div class="panel panel-primary">
    <div class="panel-heading">    <div class="pull-right">
        <div class="summary"></div>
    </div>
    <h3 class="panel-title">
        <i class="glyphicon glyphicon-list"></i> Pago de Preinstalacion
    </h3>
    <div class="clearfix"></div></div>
    <div class="kv-panel-before"> 
       <div class="btn-toolbar kv-grid-toolbar toolbar-container pull-right">    
    <div class="clearfix"></div></div>
   
    </div>
    <div id="crud-datatable-estadocuenta-container" class="table-responsive kv-grid-container">
        <table class="kv-grid-table table table-bordered table-condensed kv-table-wrap"><colgroup><col><col><col class="skip-export"></colgroup>
<thead>

<tr>
    <th data-col-seq="0" style="width: 30%;">Estado Pago</th>
    <th data-col-seq="1" style="width: 50%;">Monto</th>
    <th data-col-seq="1" style="width: 20%;">Accion</th>
</tr>

</thead>
<tbody> 
$mensaje
$cols

</tbody>
</table></div>
    <div class="kv-panel-after"></div>    
</div></div>
EOF;
        return $panel;
    }

    function getRow($row) {

            $res = '<tr data-key="estadocuenta" class="bg-danger"> ';
            $res .= '<td data-col-seq="0">'.$row['estadopago'].'</td>';
            $res .= '<td data-col-seq="1">'.$row['monto'].' Gs.</td>';
            $res .= '<td data-col-seq="2"><input type="button" class="btn btn-success" value="Pagar Preinstalacion" 
                        id="paidpre" name="paidpre"></td>';

            //$res .= '<td data-col-seq="2">'.$row['monto'].'</td>';
            //$res .= '<td data-col-seq="3">'.$row['monto'].'</td>';
            $res .= '</tr>';
            return $res;
    }



    function generarReciboConPago($clienteid, $numerorecibo, $empresa, $cobrador, $fechaemision,$estadocuentalist,
                                  $buscarEstadoCuenta){

        try{
            $recibo = self::findModel($numerorecibo);

            if($recibo == null){
                //Significa que no existe recibo

                //Debo hacer el insert
                $recibo = new Recibo();
                $recibo->numero = $numerorecibo;
                $recibo->numerorecibo = $numerorecibo;
                $recibo->clienteid = $clienteid;
                $recibo->empresa = $empresa;
                $recibo->estadopago = 'Pagado';
                $recibo->cobrador = $cobrador;
                $recibo->fechaemision = $fechaemision;
                $recibo->created_at = date('d-m-Y');
                $recibo->modified_at = date('d-m-Y');
                $recibo->created_by = Yii::$app->user->identity->username;

                if($recibo->save()){
                    return self::generarReciboDetalleConPago($recibo,$estadocuentalist,$buscarEstadoCuenta);
                }else{
                    return 'No se pudo guardar';
                }


            }else{
                return self::generarReciboDetalleConPago($recibo,$estadocuentalist,$buscarEstadoCuenta);

            }

        }catch (\Exception $e) {
            print_r( $e->getMessage(). "\n");
            return 'Excepción ReciboPAgo: '.  $e->getMessage(). "\n";
        }
        return 'Vacio';
    }

    function generarReciboDetalleConPago($recibo,$estadocuentalist,$buscarEstadoCuenta){
        $contratolocal = '';
        try{

            if($buscarEstadoCuenta){

                $db = Yii::$app->db;
                try{
                    $i=0;
                    foreach ($estadocuentalist as $fila){
                        if($fila != '' and $fila != 0 ){


                            $query = <<<EOF
    select monto,contrato from estadocuenta where estadocuentaid = :estadocuentaid
EOF;

                            $cmd=$db->createCommand($query)->bindValues(['estadocuentaid'=>$fila]);
                            $estadoMonto = $cmd->queryOne();
                            $recibodetalle =new Recibodetalle();

                            $recibodetalle->numerorecibo = $recibo->numero;
                            $recibodetalle->estadocuentaid = $fila;
                            $recibodetalle->empresa = $recibo->empresa;
                            $recibodetalle->clienteid = $recibo->clienteid;
                            $recibodetalle->periodo = 'Q1';
                            $recibodetalle->tipopago = 'Mensualidad';
                            $recibodetalle->monto = $estadoMonto['monto'];
                            $contratolocal = $estadoMonto['contrato'];
                            $recibodetalle->created_at = date('d-m-Y');
                            $recibodetalle->modified_at = date('d-m-Y');
                            $recibodetalle->created_by = Yii::$app->user->identity->username;
                            $recibodetalle->save();

                            $query = <<<EOF
    update estadocuenta set numerorecibo = :numerorecibo where estadocuentaid = :estadocuentaid
EOF;

                            $cmd=$db->createCommand($query)->bindValues(['numerorecibo'=>$recibo->numero,'estadocuentaid'=>$fila]);
                            $cmd->execute();


                        }
                    }

                }catch (\Exception $e) {
                    print_r("ERROR FOREACH PARA MESES: ".$e->getMessage() . "\n");
                }

            }else{
                foreach ($estadocuentalist as $rows){
                    $recibodetalle =new Recibodetalle();

                    $recibodetalle->numerorecibo = $recibo->numero;
                    $recibodetalle->estadocuentaid = $rows['estadocuentaid'];
                    $recibodetalle->empresa = $recibo->empresa;
                    $recibodetalle->clienteid = $recibo->clienteid;
                    $recibodetalle->periodo = 'Q1';
                    $recibodetalle->tipopago = 'Mensualidad';
                    $recibodetalle->monto = $rows['monto'];
                    $recibodetalle->created_at = date('d-m-Y');
                    $recibodetalle->modified_at = date('d-m-Y');
                    $recibodetalle->created_by = Yii::$app->user->identity->username;
                    try{
                        $recibodetalle->save();
                        $db = Yii::$app->db;
                        $query = <<<EOF
                        
    update estadocuenta set numerorecibo = :numerorecibo where estadocuentaid = :estadocuentaid
EOF;

                        $cmd=$db->createCommand($query)->bindValues(['numerorecibo'=>$recibo->numero,'estadocuentaid'=>$rows['estadocuentaid']]);
                        $cmd->execute();
                    }catch (\Exception $e) {
                        print_r("ERROR FOREACH: ".$e->getMessage() . "\n");
                    }

                }
            }
            //TODO Verificar que responder, cuando se realice un pago
            return 'Se genero el Pago con los recibos correspondientes';
        }catch (\Exception $e) {
            print_r( $e->getMessage(). "\n");
            return 'Excepción capturada: '.  $e->getMessage(). "\n";

        }

    }

    public function AccionesPostPagoRecibo(){


    }


    public function actionCheckpreinstalacion(){
        try{
            $datos = $_POST['checkPre'];
            return self::datosParaPagarPreinstalacion($datos['empresa'],$datos['clienteid'],$datos['contrato']);
        }catch (\Exception $e) {
            print_r( $e->getMessage(). "\n");
            return 'Excepción ReciboPAgo: '.  $e->getMessage(). "\n";
        }

    }

    public function actionLastpaid(){
        $datos = $_POST['lastpaid'];
        return self::generarUltimoPago($datos['clienteid'],$datos['contrato']);
    }

    function generarUltimoPago($clienteid,$contrato){

        $query = <<< EOF
select recibo.numerorecibo,recibo.estadopago,recibo.fechaemision,sum(r.monto) as monto

from recibo
 inner join recibodetalle r on recibo.numerorecibo = r.numerorecibo and recibo.clienteid = r.clienteid
  inner join estadocuenta ec on ec.estadocuentaid = r.estadocuentaid

where recibo.clienteid = :clienteid and ec.contrato = :contrato
group by recibo.numerorecibo,recibo.estadopago,recibo.fechaemision
order by recibo.fechaemision desc ;
EOF;
        $db = Yii::$app->db;
        $cmd=$db->createCommand($query)->bindValues(['clienteid'=> $clienteid,'contrato'=>$contrato]);

        $pagosRealizados = $cmd->queryAll();

        if(count($pagosRealizados)>0){
            return self::panelUltimoPago($pagosRealizados,true);
        }else{
            return self::panelUltimoPago($pagosRealizados,false);
        }


    }


    function panelUltimoPago($params,$existePago) {
        $cols = "";


        $mensaje = '';

        if($existePago){
            foreach ($params as $fila){
                $aux = self::getRowUltimoPagos($fila);
                $cols .= $aux;
                $mensaje = '';
            }

        }else{

            $mensaje = '<tr data-key="estadoultimo" class="bg-success"> ';
            $mensaje .= '<td data-col-seq="0" colspan="4"><center>No existen Pagos registrados</center></td>';
            $mensaje .= '</tr>';
        }


        $panel = <<< EOF
<div id="crud-datatable-ultimopago" class="grid-view hide-resize" data-krajee-grid="kvGridInit_ebe0c92c">
<div class="panel panel-primary">
    <div class="panel-heading">    <div class="pull-right">
        <div class="summary"></div>
    </div>
    <h3 class="panel-title">
        <i class="glyphicon glyphicon-list"></i> Ultimos Pagos
    </h3>
    <div class="clearfix"></div></div>
    <div class="kv-panel-before"> 
       <div class="btn-toolbar kv-grid-toolbar toolbar-container pull-right">    
    <div class="clearfix"></div></div>
   
    </div>
    <div id="crud-datatable-estadocuenta-container" class="table-responsive kv-grid-container">
        <table class="kv-grid-table table table-bordered table-condensed kv-table-wrap"><colgroup><col><col><col class="skip-export"></colgroup>
<thead>

<tr>
    <th data-col-seq="0" style="width: 25%;">Fecha</th>
    <th data-col-seq="1" style="width: 25%;">Numero Recibo</th>
    <th data-col-seq="2" style="width: 25%;">Estado</th>
    <th data-col-seq="3" style="width: 25%;">monto</th>
</tr>

</thead>
<tbody> 
$mensaje
$cols

</tbody>
</table></div>
    <div class="kv-panel-after"></div>    
</div></div>
EOF;
        return $panel;
    }

    function getRowUltimoPagos($row) {

        $res = '<tr data-key="estadocuenta" class="bg-success"> ';
        $res .= '<td data-col-seq="0">'.$row['fechaemision'].'</td>';
        $res .= '<td data-col-seq="1">'.$row['numerorecibo'].' </td>';
        $res .= '<td data-col-seq="2">'.$row['estadopago'].'</td>';
        $res .= '<td data-col-seq="3">'.$row['monto'].' Gs.</td>';

        //$res .= '<td data-col-seq="2">'.$row['monto'].'</td>';
        //$res .= '<td data-col-seq="3">'.$row['monto'].'</td>';
        $res .= '</tr>';
        return $res;
    }


    public function actionPagar($empresa,$clienteid,$contrato)
    {
        $request = Yii::$app->request;
        $model = new Recibo();
        $model->empresa = Yii::$app->user->identity->empresa;
        $model->clienteid = $clienteid;
        $model->numero = self::nextNumeroRecibo();
        $model->fechaemision = date('d-m-Y');
        if ($model->hasProperty('created_by')) {
            $model->created_at = date('d-m-Y');
            $model->modified_at = date('d-m-Y');
            $model->created_by = Yii::$app->user->identity->username;
        }
        if(isset($_GET['_pjax']) && !empty($_GET['_pjax'])) {
            return;
        }
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> Yii::t('app', "Add")." ".Yii::t('app', $this->title),
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'contrato' =>$contrato
                    ]),
                    'footer'=> Html::button( Yii::t('app', 'Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button( Yii::t('app', 'Save'),['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> Yii::t('app', "Add")." ".Yii::t('app', $this->title),
                    'content'=>'<span class="text-success">Crear Recibo realizado</span>',
                    'footer'=> Html::button(Yii::t('app', 'Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::a(Yii::t('app', 'Create More'),['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];
            }else{
                return [
                    'title'=> Yii::t('app', "Add")." ".Yii::t('app', $this->title),
                    'content'=>$this->renderAjax('create', [
                        'model' => $model
                        ,
                        'contrato' =>$contrato
                    ]),
                    'footer'=> Html::button(Yii::t('app','Cerrar'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button(Yii::t('app','Guardar'),['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['updatemd', 'numerorecibo' => $model->numerorecibo]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'contrato' =>$contrato
                ]);
            }
        }

    }


    /**
     * Updates an existing Recibo model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $numerorecibo
     * @return mixed
     */
    public function actionUpdate($numerorecibo)
    {
        $request = Yii::$app->request;  		
        $model = $this->findModel($numerorecibo);
		if ($model->hasProperty('created_by')) {
            $model->modified_at = date('d-m-Y');
            $model->modified_by = Yii::$app->user->identity->username;
        }
		$model->fechaemision = Tools::dateFromdb($model->fechaemision); 
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> Yii::t('app', "Update")." ".Yii::t('app', $this->title),
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button(Yii::t('app', 'Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button(Yii::t('app', 'Save'),['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> Yii::t('app', "Update")." ".Yii::t('app', $this->title),
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a(Yii::t('app','Edit'),['update','numerorecibo'=>$numerorecibo],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> Yii::t('app', "Update")." ".Yii::t('app', $this->title),
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'numerorecibo' => $model->numerorecibo]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }
 
/***
* UPDATE MASTER DETAIL
* 
*/

public function actionUpdatemd($numerorecibo)
    {
        $request = Yii::$app->request;
        if(isset($_GET['_pjax']) && !empty($_GET['_pjax'])) {
            return;
        }	   		
        $model = $this->findModel($numerorecibo);
		if ($model->hasProperty('created_by')) {
            $model->modified_at = date('d-m-Y');
            $model->modified_by = Yii::$app->user->identity->username;
        }
		$model->fechaemision = Tools::dateFromdb($model->fechaemision); 
		$searchModel = new RecibodetalleBuscar();
			$searchModel->numerorecibo = $numerorecibo;
		$extraparams = null; 
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$extraparams);
		
		/*
		*   Process for non-ajax request
		*/
		if ($model->load($request->post()) && $model->save()) {
			return $this->redirect(['index', 'numerorecibo' => $model->numerorecibo]);
		} else {
			return $this->render('update_master_detail', [
				'title'=> Yii::t('app', "Update")." ".Yii::t('app', $this->title),
				'model' => $model,
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);
		}
    }
    /**
     * Delete an existing Recibo model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $numerorecibo
     * @return mixed
     */
    public function actionDelete($numerorecibo)
    {
        $request = Yii::$app->request;
        $this->findModel($numerorecibo)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing Recibo model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $numerorecibo
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            // $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the Recibo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $numerorecibo
     * @return Recibo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($numerorecibo)
    {
        if (($model = Recibo::findOne(['numerorecibo' => $numerorecibo])) !== null) {
            return $model;
        } else {
            return null;
        }
    }
}

/*
*/

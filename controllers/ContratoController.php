<?php

namespace app\controllers;

use app\models\Financiaciondisponible;
use app\models\Plan;
use app\models\Promodisponible;
use Yii;
use yii\base\ErrorException;
use app\models\Contrato;
use app\models\ContratoBuscar;
use yii\web\Controller;
use app\models\Buscar;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;
use app\models\Authmanager;
use app\models\Tools;
use yii\helpers\Inflector;
use app\models\Financiacion;
use  app\models\Promocion;

/**
 * ContratoController implements the CRUD actions for Contrato model.
 */
class ContratoController extends Controller
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
     * Lists all Contrato models.
     * @return mixed
     */
    public function actionIndex()
    {

		$searchModel = new ContratoBuscar();
		$searchModel->empresa = Yii::$app->user->identity->empresa;
		$extraparams = null; //$extraparams['key'] = 'value';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$extraparams);

        return $this->render('index', [
		    'title' => $this->titleplural,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPreinstalaciones(){
        $searchModel = new ContratoBuscar();
        $searchModel->empresa = Yii::$app->user->identity->empresa;
        //print_r(Yii::$app->request->queryParams);
        $params['estado'] = 'Preinstalacion';
        //print_r($params);
        //return;
        //Yii::$app->request->queryParams[] = ['estado'=>'Prospecto'];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$params);

        return $this->render('index', [
            'title' => 'Preinstalaciones',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInstalaciones(){
        $searchModel = new ContratoBuscar();
        $searchModel->empresa = Yii::$app->user->identity->empresa;
        //print_r(Yii::$app->request->queryParams);
        $params['estado'] = 'Instalacion';
        //print_r($params);
        //return;
        //Yii::$app->request->queryParams[] = ['estado'=>'Prospecto'];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$params);

        return $this->render('index', [
            'title' => 'Instalaciones',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Contrato model.
     * @param string $empresa
     * @param string $contrato
     * @return mixed
     */
    public function actionView($empresa, $contrato)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> Yii::t('app',$this->title)."# ".$empresa, $contrato,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($empresa, $contrato),
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a(Yii::t('app','Edit'),['update','empresa, $contrato'=>$empresa, $contrato],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($empresa, $contrato),
            ]);
        }
    }

    /**
     * Funcion que retorna la lista de promociones disponibles de acuerdo al plan seleccionado
     */
    public function actionPromolist(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $empresa = Yii::$app->user->identity->empresa;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = Promodisponible::find()->andWhere(['plan' => $id,'empresa'=>$empresa])->asArray()->all();
            $selected  = null;
            $c=0;
            if ($id != null && count($list) > 0) {
                $selected = '';
                Yii::info('in the if now Here');
                foreach ($list as $i => $account) {
                    $c++;
                    $out[] = ['id' => $account['promocion'], 'name' => $account['promocion']];
                    if ($i == 0) {
                       $selected = $account['promocion'];
                    }
                }
                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public function actionFinanlist(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $empresa = Yii::$app->user->identity->empresa;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = Financiaciondisponible::find()->andWhere(['plantv' => $id,'empresa'=>$empresa])->asArray()->all();
            $selected  = null;
            $c=0;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $c++;
                    $out[] = ['id' => $account['financiacion'], 'name' => $account['financiacion']];
                    if ($i == 0) {
                        $selected = $account['financiacion'];
                    }
                }
                return ['output' => $out, 'selected' => ''];
            }

        }
        return ['output' => '', 'selected' => ''];
    }

    public function actionPlanlist(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $empresa = Yii::$app->user->identity->empresa;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = Plan::find()->andWhere(['modalidad' => $id,'empresa'=>$empresa])->asArray()->all();
            $selected  = null;
            $c=0;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $c++;
                    $out[] = ['id' => $account['plan'], 'name' => $account['plan']];
                    if ($i == 0) {
                        $selected = $account['plan'];
                    }
                }
                return ['output' => $out, 'selected' => ''];
            }

        }
        return ['output' => '', 'selected' => ''];
    }

    public function insertarContrato($datos,$save){

        $model = new Contrato();
        $model->empresa = Yii::$app->user->identity->empresa;
        $model->contrato = $datos["contrato"];
        $model->clienteid =  $datos["clienteid"];
        $model->vendedor = $datos["vendedor"];
        $model->plan = $datos["plan"];
        $model->promocion = $datos["promocion"];
        $model->financiacion = $datos["financiacion"];
        $model->estado='Venta';
        $model->fechainicio = $datos["fechainicio"];
        $model->fechafin = Tools::agregarTiempoAFecha($model->fechainicio,$model->duracion,'months');
        $model->equipos = $datos["equipos"];
        $model->observaciones = $datos["obs"];
        $model->created_by = Yii::$app->user->identity->username;
        $model->duracion = $datos["duracion"];
        $model->diavto = $datos["diavto"];
        $model->modalidad = $datos["modalidad"];


        /*if ($model->hasProperty('created_by')) {
            $model->created_at = date('d-m-Y');
            $model->modified_at = date('d-m-Y');
            $model->created_by = Yii::$app->user->identity->username;
        }*/
        Yii::info($model);

        try {
            if($save){
                if($model->save(false)){
                  //  Yii::info('Se generan nuevos datos');
                    return $this->generarEstadoCuenta($model->empresa,$model->contrato);
                };
            }else{
                $model2 = $this->findModel($model->empresa, $model->contrato);
               // Yii::info('Se obtiene el dato existente');

                if ($model2->hasProperty('created_by')) {
                    $model2->modified_at = date('d-m-Y');
                    $model2->modified_by = Yii::$app->user->identity->username;
                }
                //$model2->fechainicio = Tools::dateFromdb($model2->fechainicio);
                $model2->plan = $datos["plan"];
                $model2->promocion = $datos["promocion"];
                $model2->financiacion = $datos["financiacion"];
                $model2->estado='Venta';
                $model2->fechainicio = $datos["fechainicio"];
                //$model->fechafin = Tools::agregarTiempoAFecha($model->fechainicio,$model->duracion,'months');
                $model2->equipos = $datos["equipos"];
                $model2->observaciones = $datos["obs"];
                $model2->created_by = Yii::$app->user->identity->username;
                $model2->duracion = $datos["duracion"];
                $model2->diavto = $datos["diavto"];
                $model2->modalidad = $datos["modalidad"];
                //$model2->fechafin = Tools::dateFromdb($model->fechafin);


                if($model2->save(false)){
                //    Yii::info('Se Actualizaron con nuevos datos');
                    return $this->generarEstadoCuenta($model2->empresa,$model2->contrato);
                };
            }


        } catch (\Exception $e) {
            print_r( $e->getMessage());
            return 'Excepción capturada: '.  $e->getMessage(). "\n";
        }

    }

    public function verificarExisteContratoVenta($clienteid){

        $db = Yii::$app->db;

        //Se verifica si el cliente tiene algun contrato en estado VENTA
        $query = <<< EOF
        select contrato,estado,clienteid
		from contrato where empresa = :empresa and clienteid = :clienteid and estado = 'Venta';
EOF;
        $cmd=$db->createCommand($query)->bindValues(['empresa'=>Yii::$app->user->identity->empresa,
            'clienteid'=>$clienteid]);
        $rows = $cmd->queryAll();

        // De tenerlo, se procede a eliminarlo
        if (count($rows)>0){
            //Se verifica si el contrato esta en estado Venta
            if($rows[0]['estado']='Venta'){

                return $rows[0]['contrato'];

            }else{
                //De no ser asi, se tiene un contrato con diferente estado
                //
                return '';
            }

        }
        return '';

    }


    public function actionGenerardetallecontrato(){
        Yii::info('Inicio GenerarDetalle');
        $datos = $_POST["aux"];
        $request = Yii::$app->request;

        $db = Yii::$app->db;

        $query = <<< EOF
        select contrato,estado 
		from contrato where contrato = :contrato and empresa = :empresa and clienteid = :clienteid;
EOF;
        $cmd=$db->createCommand($query)->bindValues(['empresa'=>Yii::$app->user->identity->empresa,
            'contrato'=>$datos["contrato"],'clienteid'=>$datos['clienteid']]);
        $rows = $cmd->queryAll();


        if (count($rows)>0){

            if($rows[0]['estado']=='Venta'){
                Yii::$app->db->createCommand()
                    ->delete('estadocuenta', ['contrato' => $datos["contrato"]])
                    ->execute();

                Yii::$app->db->createCommand()
                    ->delete('contratodetalle', ['contrato' => $datos["contrato"]])
                    ->execute();

              //  Yii::info('Borre los detalles');

              //  Yii::info('Genero de nuevo los detalles');
                return $this->insertarContrato($datos,false);



            }else{
                  Yii::info('Muestro Estado Cuenta de un contrato existente');
                return $this->generarEstadoCuenta(Yii::$app->user->identity->empresa,$rows[0]['contrato']);
            }

        }else{

            $query = <<< EOF
        select contrato,estado 
		from contrato where empresa = :empresa and clienteid = :clienteid;
EOF;
            $cmd=$db->createCommand($query)->bindValues(['empresa'=>Yii::$app->user->identity->empresa,
                'clienteid'=>$datos['clienteid']]);
            $rows2 = $cmd->queryAll();

            if (count($rows2)>0){
                try{
                    if($rows2[0]['estado']='Venta') {
                        Yii::$app->db->createCommand()
                            ->delete('estadocuenta', ['contrato' => $rows2[0]["contrato"]])
                            ->execute();

                        Yii::$app->db->createCommand()
                            ->delete('contratodetalle', ['contrato' => $rows2[0]["contrato"]])
                            ->execute();
                        Yii::$app->db->createCommand()
                            ->delete('contrato', ['contrato' => $rows2[0]["contrato"]])
                            ->execute();

                        //Yii::info('Borre el contrato anterior');

                       // Yii::info('Genero El nuevo contrato');


                        return $this->insertarContrato($datos, true);
                    }

                }catch (\Exception $e) {
                    print_r( $e->getMessage());
                    return 'Excepción capturada: '.  $e->getMessage(). "\n";
                }

            }else{
                   Yii::info('Logica para cuando no es ESTA en Estado Venta 2');
                }

            }


           // Yii::info('No hay Datos');

            return $this->insertarContrato($datos,true);

        }



    public function cambiarEstadoContrato($empresa,$contrato){
        try{

        $db = Yii::$app->db;
        $query = <<< EOF
         select ec.estadopago,sum(ec.monto) as suma,ec.grupoproducto,c.clienteid
from estadocuenta ec
inner join contrato c on ec.contrato = c.contrato
where ec.contrato = :contrato and ec.empresa = :empresa 
and (ec.grupoproducto = 'Preinstalacion' or ec.subgrupoproducto = 'Preinstalacion')
group by ec.estadopago,ec.grupoproducto,c.clienteid;
        
EOF;
        $cmd=$db->createCommand($query)->bindValues(['empresa'=>$empresa,
            'contrato'=>$contrato]);
        $rows = $cmd->queryAll();
        $newState='';
        $clienteid='';
        if($rows[0]['suma'] >= 0){
            //Significa que hay un monto a pagar
            $newState = 'Preinstalacion';
        }else{
            $newState = 'Instalacion';
        }
        $clienteid=$rows[0]['clienteid'] ;

            $query = <<< EOF
        update contrato set estado = :estado where contrato= :contrato and empresa = :empresa;
EOF;
            $db->createCommand($query)->bindValues(['empresa'=>$empresa,
                'contrato'=>$contrato,'estado'=>$newState])->execute();

            $query = <<< EOF
        update clientes set estado = :estado,contrato = :contrato where clienteid= :clienteid and empresa = :empresa;
EOF;
            $db->createCommand($query)->bindValues(['empresa'=>$empresa,
                'clienteid'=>$clienteid,'estado'=>$newState,'contrato'=>$contrato])->execute();

            return 'done';
        }catch (\Exception $e) {
            print_r( $e->getMessage());
            return 'Excepción capturada: '.  $e->getMessage(). "\n";
        }


    }

    public function actionManejoestado(){
        Yii::info('Inicio GenerarDetalle');
        $datos = $_POST["info"];
        $resp =self::cambiarEstadoContrato(Yii::$app->user->identity->empresa,$datos['contrato']);
        if( $resp== 'done'){
            //Se realizo el cambio correctamente
            return ''.Yii::$app->urlManager->createUrl('contrato/view').'?empresa='.Yii::$app->user->identity->empresa.'&contrato='.$datos['contrato'].'';
        }else{
            //Hubo problemas con el cambio
            return $resp;
        }


    }

    /**
     * Creates a new Contrato model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */


    public static function generarEstadoCuenta($empresa,$contrato){

       // Yii::$app->response->format = Response::FORMAT_JSON;
        $db = Yii::$app->db;

        $query = <<< EOF
        select empresa,contrato,producto,vencimiento,numerocuota,monto,estadopago,grupoproducto
from estadocuenta
where contrato = :contrato and empresa = :empresa
group by empresa,contrato,producto,monto,vencimiento,numerocuota,estadopago,grupoproducto
order by numerocuota,producto;
        
EOF;
        $cmd=$db->createCommand($query)->bindValues(['empresa'=>$empresa,
            'contrato'=>$contrato]);
        $rows = $cmd->queryAll();

        //Yii::info($rows);

        $query = <<< EOF
        select numerocuota,sum(monto) as suma
from estadocuenta
where contrato = :contrato and empresa = :empresa and (estadopago='Pendiente' or estadopago='Vencido')
group by numerocuota
order by numerocuota;
        
EOF;
        $cmd=$db->createCommand($query)->bindValues(['empresa'=>$empresa,
            'contrato'=>$contrato]);
        $rows2 = $cmd->queryAll();


        return self::panel($rows,$rows2);

    }


    function panel($params,$params2) {
        $cols = "";
        $i=0;
        $nextnumerocuota=1;
        $montoMes=0;
        foreach ( $params as $row) {
            if($row['estadopago']=='Pagado'){
                $montoMes += $row['monto'];
            }

            $aux = self::getRow($row);
            $cols .= $aux;
            if($row['numerocuota']!=$nextnumerocuota){
                $ban = false;
                if($montoMes == $params2[$i]['suma']){
                    $ban = true;
                }
                $aux = self::getRowHead($params2[$i],$ban);
                $cols .= $aux;
                $i++;
                $nextnumerocuota++;
            }
        }

        $panel = <<< EOF
<div id="crud-datatable-estadocuenta" class="grid-view hide-resize" data-krajee-grid="kvGridInit_ebe0c92c">
<div class="panel panel-primary">
    <div class="panel-heading">    <div class="pull-right">
        <div class="summary"></div>
    </div>
    <h3 class="panel-title">
        <i class="glyphicon glyphicon-list"></i> Estado de Cuenta
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
    <th data-col-seq="0" style="width: 30%;">Producto</th>
    <th data-col-seq="1" style="width: 30%;">Estado Pago</th>
    <th data-col-seq="1" style="width: 20%;">Numero Cuota</th>
    <th data-col-seq="1" style="width: 20%;">Monto</th>
</tr>

</thead>
<tbody> 
$cols

</tbody>
</table></div>
    <div class="kv-panel-after"></div>    
</div></div>
EOF;
        return $panel;
    }

    function getRow($row) {
        if( !($row['monto']==0 && ($row['grupoproducto'] != 'promo' && $row['grupoproducto'] != 'financiacion'))){
            if($row['estadopago']=='Pagado'){
                $res = ' <tr data-key="estadocuenta" class="bg-success"> ';
            }else{
                $res = ' <tr data-key="estadocuenta"> ';
            }

            $res .= '<td data-col-seq="0">'.$row['producto'].'</td>';
            $res .= '<td data-col-seq="1">'.$row['estadopago'].'</td>';
            $res .= '<td data-col-seq="2">'.$row['numerocuota'].'</td>';
            $res .= '<td data-col-seq="3">'.$row['monto'].'</td>';
            $res .= '</tr>';
            return $res;
        }else{
            return '';
        }

    }
    function getRowHead($row,$ban) {
       if($ban){
           $res = ' <tr data-key="estadocuenta" class="bg-success"> ';

        }else{
            $res = ' <tr data-key="estadocuenta" class="bg-danger"> ';
        }
        $res .= '<td data-col-seq="1" colspan="2">'.'<center>'.'Total Mes #'.$row['numerocuota'].'</center>'.'</td>';
        $res .= '<td data-col-seq="2" colspan="2">'.'<center>'.$row['suma'].'</center>'.'</td>';
        $res .= '</tr>';
        return $res;
    }

    public function actionVenta($empresa, $clienteid)
    {
        $existeContrato = self::verificarExisteContratoVenta($clienteid);

        if($existeContrato !=''){
            return self::actionUpdateventa(Yii::$app->user->identity->empresa,$existeContrato);

        }
        $request = Yii::$app->request;
        $model = new Contrato();
        $model->empresa = Yii::$app->user->identity->empresa;
        if ($model->hasProperty('created_by')) {
            $model->created_at = date('d-m-Y');
            $model->modified_at = date('d-m-Y');
            $model->created_by = Yii::$app->user->identity->username;
        }
        if(isset($_GET['_pjax']) && !empty($_GET['_pjax'])) {
            return;
        }
        $existeContrato = self::verificarExisteContratoVenta($clienteid);

        if($existeContrato !=''){
            return self::actionUpdateventa(Yii::$app->user->identity->empresa,$existeContrato);

        }
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                $model->clienteid = $clienteid;
                $model->fechainicio = date('d-m-Y');
                $model->equipos = 1;
                $model->duracion = 12;


                //$model->estado = 'Venta';
                $model->contrato = $model->numeroContrato($model->empresa);
                //$model->promocion = Promocion::byDefault(Yii::$app->user->identity->empresa);
                //$model->financiacion= Financiacion::byDefault(Yii::$app->user->identity->empresa);

                return [
                    'title'=> Yii::t('app', "Add")." ".Yii::t('app', $this->title),
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button( Yii::t('app', 'Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button( Yii::t('app', 'Save'),['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post())){
                $model->estado = 'Venta';
                $model->fechafin = Tools::agregarTiempoAFecha($model->fechainicio,$model->duracion,'months');
                $model->save(false);
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> Yii::t('app', "Add")." ".Yii::t('app', $this->title),
                    'content'=>'<span class="text-success">Crear Contrato realizado</span>',
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
            if ($model->load($request->post())) {
                $model->fechafin = Tools::agregarTiempoAFecha($model->fechainicio,$model->duracion,'months');
                $model->save();
                return $this->redirect(['updatemd', 'empresa' => $model->empresa, 'contrato' => $model->contrato]);
            } else {

                $model->clienteid = $clienteid;
                $model->fechainicio = date('d-m-Y');
                $model->equipos = 1;
                $model->duracion = 12;
                //$model->estado = 'Venta';
                //$model->fechafin = Tools::agregarTiempoAFecha($model->fechainicio,$model->duracion,'months');
                $model->contrato = $model->numeroContrato($model->empresa);
                //$model->promocion = Promocion::byDefault(Yii::$app->user->identity->empresa);
                //$model->financiacion= Financiacion::byDefault(Yii::$app->user->identity->empresa);




                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

    }
    /**
     * Creates a new Contrato model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;   		
        $model = new Contrato();
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
                    'content'=>'<span class="text-success">Crear Contrato realizado</span>',
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
                return $this->redirect(['updatemd', 'empresa' => $model->empresa, 'contrato' => $model->contrato]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }



    public function actionUpdateventa($empresa, $contrato)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($empresa, $contrato);
        if ($model->hasProperty('created_by')) {
            $model->modified_at = date('d-m-Y');
            $model->modified_by = Yii::$app->user->identity->username;
        }
        $model->fechainicio = Tools::dateFromdb($model->fechainicio);
        $model->fechafin = Tools::dateFromdb($model->fechafin);
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
                    'title'=> Yii::t('app', "Update")." ".Yii::t('app', $this->title),
                    'content'=>$this->renderAjax('updateventa', [
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
                        Html::a(Yii::t('app','Edit'),['updateventa','empresa, $contrato'=>$empresa, $contrato],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                return [
                    'title'=> Yii::t('app', "Update")." ".Yii::t('app', $this->title),
                    'content'=>$this->renderAjax('updateventa', [
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
                return $this->redirect(['view', 'empresa' => $model->empresa, 'contrato' => $model->contrato]);
            } else {
                return $this->render('updateventa', [
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     * Updates an existing Contrato model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param string $empresa
     * @param string $contrato
     * @return mixed
     */
    public function actionUpdate($empresa, $contrato)
    {
        $request = Yii::$app->request;  		
        $model = $this->findModel($empresa, $contrato);
		if ($model->hasProperty('created_by')) {
            $model->modified_at = date('d-m-Y');
            $model->modified_by = Yii::$app->user->identity->username;
        }
		$model->fechainicio = Tools::dateFromdb($model->fechainicio); 
		$model->fechafin = Tools::dateFromdb($model->fechafin); 
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
                            Html::a(Yii::t('app','Edit'),['update','empresa, $contrato'=>$empresa, $contrato],['class'=>'btn btn-primary','role'=>'modal-remote'])
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
                return $this->redirect(['view', 'empresa' => $model->empresa, 'contrato' => $model->contrato]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     * Delete an existing Contrato model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $empresa
     * @param string $contrato
     * @return mixed
     */
    public function actionDelete($empresa, $contrato)
    {
        $request = Yii::$app->request;

        $model = $this->findModel($empresa, $contrato)->delete();

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
     * Delete multiple existing Contrato model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $empresa
     * @param string $contrato
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
     * Finds the Contrato model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $empresa
     * @param string $contrato
     * @return Contrato the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($empresa, $contrato)
    {
        if (($model = Contrato::findOne(['empresa' => $empresa, 'contrato' => $contrato])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

/*
*/

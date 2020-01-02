<?php

namespace app\controllers;

use Yii;
use yii\base\ErrorException;
use app\models\Serviciocliente;
use app\models\ServicioclienteBuscar;
use app\models\ServicioclienteBuscarTecnico;
use yii\web\Controller;
use app\models\ServicioclientedetalleBuscar;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;
use app\models\Authmanager;
use app\models\Tools;
use yii\helpers\Inflector;

/**
 * ServicioclienteController implements the CRUD actions for Serviciocliente model.
 */
class ServicioclienteController extends Controller
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
     * Lists all Serviciocliente models.
     * @return mixed
     */
    public function actionIndex()
    {    
               
		$searchModel = new ServicioclienteBuscar();
		$searchModel->empresa = Yii::$app->user->identity->empresa;
		$extraparams = null; //$extraparams['key'] = 'value';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$extraparams);

        return $this->render('index', [
		    'title' => $this->titleplural,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionIndextecnico()
    {
        $searchModel = new ServicioclienteBuscarTecnico();
        $searchModel->empresa = Yii::$app->user->identity->empresa;
        $searchModel->tecnico = Yii::$app->user->identity->id;
        $extraparams = null; //$extraparams['key'] = 'value';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$extraparams);

        return $this->render('index_tecnico', [
            'title' => $this->titleplural,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Serviciocliente model.
     * @param string $empresa
     * @param string $contrato
     * @param string $tiposervicio
     * @param string $fechasolicitud
     * @return mixed
     */
    public function actionView($empresa, $contrato, $tiposervicio, $fechasolicitud)
    {   
        $request = Yii::$app->request; 		
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> Yii::t('app',$this->title)."# ".$empresa, $contrato, $tiposervicio, $fechasolicitud,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($empresa, $contrato, $tiposervicio, $fechasolicitud),
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a(Yii::t('app','Edit'),['update','empresa, $contrato, $tiposervicio, $fechasolicitud'=>$empresa, $contrato, $tiposervicio, $fechasolicitud],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($empresa, $contrato, $tiposervicio, $fechasolicitud),
            ]);
        }
    }

    /**
     * Creates a new Serviciocliente model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;   		
        $model = new Serviciocliente();
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
                    'content'=>'<span class="text-success">Crear Serviciocliente realizado</span>',
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
                return $this->redirect(['updatemd', 'empresa' => $model->empresa, 'contrato' => $model->contrato, 'tiposervicio' => $model->tiposervicio, 'fechasolicitud' => $model->fechasolicitud]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }


    public function actionAsignar($empresa, $contrato, $tiposervicio, $fechasolicitud){
        $request = Yii::$app->request;
        $model = $this->findModel($empresa, $contrato, $tiposervicio, $fechasolicitud);
        $model->fechasolicitud = Tools::dateFromdb($model->fechasolicitud);
        $model->fecharealizacion = Tools::dateFromdb($model->fecharealizacion);

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
                        Html::a(Yii::t('app','Edit'),['update','empresa, $contrato, $tiposervicio, $fechasolicitud'=>$empresa, $contrato, $tiposervicio, $fechasolicitud],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                return [
                    'title'=> Yii::t('app', "Update")." ".Yii::t('app', $this->title),
                    'content'=>$this->renderAjax('asignar', [
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
                if($model->estado == 'Realizado'){
                    Tools::cambioEstadoContratoCliente($empresa,$contrato,'Activo',self::findClientId($empresa,$contrato));
                    self::setFechaInstalacionContrato($empresa,$contrato,$model->fecharealizacion);
                }
                return $this->redirect(['view', 'empresa' => $model->empresa, 'contrato' => $model->contrato, 'tiposervicio' => $model->tiposervicio, 'fechasolicitud' => $model->fechasolicitud]);
            } else {
                return $this->render('asignar', [
                    'model' => $model,
                ]);
            }
        }

    }

    public function actionCheckdisponibilidad(){
        try{
        $datos = $_POST["tecni"];
        $tecnico = $datos['tecnico'];


        $db = Yii::$app->db;

        //Se verifica si el cliente tiene algun contrato en estado VENTA
        $query = <<< EOF
        select sc.tecnico,count(sc.tecnico) as cantidad
  from "user" u
  left join serviciocliente sc on u.id = sc.tecnico
  where u.profile = 'Tecnico' and u.id = :tecnico and sc.estado = 'Pendiente' and sc.empresa = :empresa
group by sc.tecnico;
EOF;
       $cmd=$db->createCommand($query)->bindValues(['empresa'=>Yii::$app->user->identity->empresa,
           'tecnico'=>$tecnico]);
       $rows = $cmd->queryOne();
       $respuesta='';

       if(count($rows)>0 && $rows['cantidad']>0){
           $cantidad = $rows['cantidad'] ;
        $respuesta = <<< EOF
<div class="alert alert-warning alert-dismissible" role="alert">
  El tecnico seleccionado tiene actualmente $cantidad  servicios asignados 
                en estado <strong>PENDIENTE!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
EOF;
       }else{
           $respuesta = <<< EOF
   <div class="alert alert-success alert-dismissible" role="alert">
               <strong>El tecnico seleccionado no tienen ningun servicio asignado.</strong>
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
EOF;
       }
       }catch (\Exception $e) {
            print_r( $e->getMessage());
            return 'Excepción capturada: '.  $e->getMessage(). "\n";
        }

        return $respuesta;
    }


    public function actionCambioestado($empresa, $contrato, $tiposervicio, $fechasolicitud){
        $request = Yii::$app->request;
        $model = $this->findModel($empresa, $contrato, $tiposervicio, $fechasolicitud);
        $model->fechasolicitud = Tools::dateFromdb($model->fechasolicitud);
        $model->fecharealizacion = Tools::dateFromdb($model->fecharealizacion);

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
                        Html::a(Yii::t('app','Edit'),['update','empresa, $contrato, $tiposervicio, $fechasolicitud'=>$empresa, $contrato, $tiposervicio, $fechasolicitud],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                return [
                    'title'=> Yii::t('app', "Update")." ".Yii::t('app', $this->title),
                    'content'=>$this->renderAjax('realizado_tecnico', [
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
                if($model->estado == 'Realizado'){
                    Tools::cambioEstadoContratoCliente($empresa,$contrato,'Activo',self::findClientId($empresa,$contrato));
                    self::setFechaInstalacionContrato($empresa,$contrato,$model->fecharealizacion);
                }
                return $this->redirect(['view', 'empresa' => $model->empresa, 'contrato' => $model->contrato, 'tiposervicio' => $model->tiposervicio, 'fechasolicitud' => $model->fechasolicitud]);
            } else {
                return $this->render('realizado_tecnico', [
                    'model' => $model,
                ]);
            }
        }

    }


    /**
     * Updates an existing Serviciocliente model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param string $empresa
     * @param string $contrato
     * @param string $tiposervicio
     * @param string $fechasolicitud
     * @return mixed
     */
    public function actionUpdate($empresa, $contrato, $tiposervicio, $fechasolicitud)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($empresa, $contrato, $tiposervicio, $fechasolicitud);
		if ($model->hasProperty('created_by')) {
            $model->modified_at = date('d-m-Y');
            $model->modified_by = Yii::$app->user->identity->username;
        }
		$model->fechasolicitud = Tools::dateFromdb($model->fechasolicitud); 
		$model->fecharealizacion = Tools::dateFromdb($model->fecharealizacion); 
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
                            Html::a(Yii::t('app','Edit'),['update','empresa, $contrato, $tiposervicio, $fechasolicitud'=>$empresa, $contrato, $tiposervicio, $fechasolicitud],['class'=>'btn btn-primary','role'=>'modal-remote'])
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
                return $this->redirect(['view', 'empresa' => $model->empresa, 'contrato' => $model->contrato, 'tiposervicio' => $model->tiposervicio, 'fechasolicitud' => $model->fechasolicitud]);
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

public function actionUpdatemd($empresa, $contrato, $tiposervicio, $fechasolicitud)
    {
        $request = Yii::$app->request;
        if(isset($_GET['_pjax']) && !empty($_GET['_pjax'])) {
            return;
        }	   		
        $model = $this->findModel($empresa, $contrato, $tiposervicio, $fechasolicitud);
		if ($model->hasProperty('created_by')) {
            $model->modified_at = date('d-m-Y');
            $model->modified_by = Yii::$app->user->identity->username;
        }
		$model->fechasolicitud = Tools::dateFromdb($model->fechasolicitud); 
		$model->fecharealizacion = Tools::dateFromdb($model->fecharealizacion); 
		$searchModel = new ServicioclientedetalleBuscar();
			$searchModel->empresa = $empresa;
			$searchModel->contrato = $contrato;
			$searchModel->tiposervicio = $tiposervicio;
			$searchModel->fechasolicitud = $fechasolicitud;
		$extraparams = null; 
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$extraparams);
		
		/*
		*   Process for non-ajax request
		*/
		if ($model->load($request->post()) && $model->save()) {
			return $this->redirect(['index', 'empresa' => $model->empresa, 'contrato' => $model->contrato, 'tiposervicio' => $model->tiposervicio, 'fechasolicitud' => $model->fechasolicitud]);
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
     * Delete an existing Serviciocliente model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $empresa
     * @param string $contrato
     * @param string $tiposervicio
     * @param string $fechasolicitud
     * @return mixed
     */
    public function actionDelete($empresa, $contrato, $tiposervicio, $fechasolicitud)
    {
        $request = Yii::$app->request;
        $this->findModel($empresa, $contrato, $tiposervicio, $fechasolicitud)->delete();

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
     * Delete multiple existing Serviciocliente model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $empresa
     * @param string $contrato
     * @param string $tiposervicio
     * @param string $fechasolicitud
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
     * Finds the Serviciocliente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $empresa
     * @param string $contrato
     * @param string $tiposervicio
     * @param string $fechasolicitud
     * @return Serviciocliente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($empresa, $contrato, $tiposervicio, $fechasolicitud)
    {
        if (($model = Serviciocliente::findOne(['empresa' => $empresa, 'contrato' => $contrato, 'tiposervicio' => $tiposervicio, 'fechasolicitud' => $fechasolicitud])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function findClientId($empresa,$contrato){
        $db = Yii::$app->db;
        $query = <<<EOF
    select clienteid from contrato where empresa = :empresa and contrato = :contrato;
EOF;
        $cmd=$db->createCommand($query)->bindValues(['empresa'=>$empresa,'contrato'=>$contrato]);
        $clienteid = $cmd->queryOne();

        return $clienteid['clienteid'];
    }


    protected function setFechaInstalacionContrato($empresa,$contrato,$fechainstalacion){
        $db = Yii::$app->db;
        $query = <<<EOF
    update contrato set fechainstalacion = :fechainstalacion where empresa = :empresa and contrato = :contrato
EOF;
        $cmd=$db->createCommand($query)->bindValues(['empresa'=>$empresa,'contrato'=>$contrato,'fechainstalacion'=>$fechainstalacion]);
        $cmd->execute();

    }
}

/*
*/

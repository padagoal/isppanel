<?php

namespace app\controllers;

use Yii;
use yii\base\ErrorException;
use app\models\Clientes;
use app\models\ClientesBuscar;
use yii\web\Controller;
use app\models\Buscar;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;
use app\models\Authmanager;
use app\models\Tools;
use yii\helpers\Inflector;

/**
 * ClientesController implements the CRUD actions for Clientes model.
 */
class ClientesController extends Controller
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
     * Lists all Clientes models.
     * @return mixed
     */
    public function actionProspectos()
    {
        $searchModel = new ClientesBuscar();
        $searchModel->empresa = Yii::$app->user->identity->empresa;
        print_r(Yii::$app->request->queryParams);
        $params['estado'] = 'Prospecto';
        print_r($params);
        //return;
        //Yii::$app->request->queryParams[] = ['estado'=>'Prospecto'];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$params);

        return $this->render('index', [
            'title' => 'Prospectos',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionPreinstalaciones()
    {
        $searchModel = new ClientesBuscar();
        $searchModel->empresa = Yii::$app->user->identity->empresa;
        print_r(Yii::$app->request->queryParams);
        $params['estado'] = 'Preinstalacion';
        print_r($params);
        //return;
        //Yii::$app->request->queryParams[] = ['estado'=>'Prospecto'];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$params);

        return $this->render('index', [
            'title' => 'Preinstalaciones',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionInstalaciones()
    {
        $searchModel = new ClientesBuscar();
        $searchModel->empresa = Yii::$app->user->identity->empresa;
        print_r(Yii::$app->request->queryParams);
        $params['estado'] = 'Instalacion';
        print_r($params);
        //return;
        //Yii::$app->request->queryParams[] = ['estado'=>'Prospecto'];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$params);

        return $this->render('index', [
            'title' => 'Instalaciones',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionClientes()
    {
        $searchModel = new ClientesBuscar();
        $searchModel->empresa = Yii::$app->user->identity->empresa;
        print_r(Yii::$app->request->queryParams);
        $params['estado'] = 'Activo';
        print_r($params);
        //return;
        //Yii::$app->request->queryParams[] = ['estado'=>'Prospecto'];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$params);

        return $this->render('index', [
            'title' => 'Clientes',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionIndex()
    {    
               
		$searchModel = new ClientesBuscar();
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
     * Displays a single Clientes model.
     * @param string $empresa
     * @param string $clienteid
     * @return mixed
     */


    public function actionView($empresa, $clienteid)
    {   
        $request = Yii::$app->request; 		
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> Yii::t('app',$this->title)."# ".$empresa, $clienteid,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($empresa, $clienteid),
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a(Yii::t('app','Edit'),['update','empresa, $clienteid'=>$empresa, $clienteid],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($empresa, $clienteid),
            ]);
        }
    }

    /**
     * Creates a new Clientes model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;   		
        $model = new Clientes();
		$model->empresa = Yii::$app->user->identity->empresa;
		if ($model->hasProperty('created_by')) {
            $model->created_at = date('d-m-Y');
            $model->modified_at = date('d-m-Y');
            $model->created_by = Yii::$app->user->identity->username;
        }
		if(isset($_GET['_pjax']) && !empty($_GET['_pjax'])) {
			return;
		}
        $this->title  = "Prospectos";
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->fechainicio = date('d-m-Y');
            $model->callcenter = Yii::$app->user->identity->getId();
            if($request->isGet){
                $model->estado = 'Prospecto';
                return [
                    'title'=> Yii::t('app', "Add")." ".Yii::t('app', $this->title), 
                    'content'=>$this->renderAjax('create', [
                        'model' => $model, 'title' =>$this->title,
                    ]),
                    'footer'=> Html::button( Yii::t('app', 'Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button( Yii::t('app', 'Save'),['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post())){
                $model->clienteid = $model->cedula;
                $model->estado = 'Prospecto';
                $model->save();
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> Yii::t('app', "Add")." ".Yii::t('app', $this->title), 
                    'content'=>'<span class="text-success">Crear Clientes realizado</span>',
                    'footer'=> Html::button(Yii::t('app', 'Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a(Yii::t('app', 'Create More'),['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> Yii::t('app', "Add")." ".Yii::t('app', $this->title),
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,'title' =>$this->title,
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
                return $this->redirect(['updatemd', 'empresa' => $model->empresa, 'clienteid' => $model->clienteid]);
            } else {
                return $this->render('create', [
                    'model' => $model,'title' =>$this->title,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing Clientes model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param string $empresa
     * @param string $clienteid
     * @return mixed
     */
    public function actionUpdate($empresa, $clienteid)
    {
        $request = Yii::$app->request;  		
        $model = $this->findModel($empresa, $clienteid);
		if ($model->hasProperty('created_by')) {
            $model->modified_at = date('d-m-Y');
            $model->modified_by = Yii::$app->user->identity->username;
        }
		$model->fechainicio = Tools::dateFromdb($model->fechainicio); 
		$model->fechacontrato = Tools::dateFromdb($model->fechacontrato);
        $this->title = "Clientes";
        if ($model->estado !== 'Prospecto') {
            $this->title  = "Prospectos";
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
                        'model' => $model, 'title' =>$this->title,
                    ]),
                    'footer'=> Html::button(Yii::t('app', 'Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button(Yii::t('app', 'Save'),['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> Yii::t('app', "Update")." ".Yii::t('app', $this->title),
                    'content'=>$this->renderAjax('view', [
                        'model' => $model, 'title' =>$this->title,
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a(Yii::t('app','Edit'),['update','empresa, $clienteid'=>$empresa, $clienteid],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> Yii::t('app', "Update")." ".Yii::t('app', $this->title),
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,'title' =>$this->title,
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
                return $this->redirect(['view', 'empresa' => $model->empresa, 'clienteid' => $model->clienteid]);
            } else {
                return $this->render('update', [
                    'model' => $model, 'title' =>$this->title,
                ]);
            }
        }
    }
    /**
     * Delete an existing Clientes model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $empresa
     * @param string $clienteid
     * @return mixed
     */
    public function actionDelete($empresa, $clienteid)
    {
        $request = Yii::$app->request;
        $this->findModel($empresa, $clienteid)->delete();

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
     * Delete multiple existing Clientes model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $empresa
     * @param string $clienteid
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
     * Finds the Clientes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $empresa
     * @param string $clienteid
     * @return Clientes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($empresa, $clienteid)
    {
        if (($model = Clientes::findOne(['empresa' => $empresa, 'clienteid' => $clienteid])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}

/*
*/

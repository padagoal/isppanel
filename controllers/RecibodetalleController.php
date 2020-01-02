<?php

namespace app\controllers;

use Yii;
use yii\base\ErrorException;
use app\models\Recibodetalle;
use app\models\RecibodetalleBuscar;
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
 * RecibodetalleController implements the CRUD actions for Recibodetalle model.
 */
class RecibodetalleController extends Controller
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
     * Lists all Recibodetalle models.
     * @return mixed
     */
    public function actionIndex()
    {    
               
		$searchModel = new RecibodetalleBuscar();
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
     * Displays a single Recibodetalle model.
     * @param integer $numerorecibo
     * @param integer $estadocuentaid
     * @param string $empresa
     * @param string $clienteid
     * @param string $periodo
     * @param string $tipopago
     * @return mixed
     */
    public function actionView($numerorecibo, $estadocuentaid, $empresa, $clienteid, $periodo, $tipopago)
    {   
        $request = Yii::$app->request; 		
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> Yii::t('app',$this->title)."# ".$numerorecibo, $estadocuentaid, $empresa, $clienteid, $periodo, $tipopago,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($numerorecibo, $estadocuentaid, $empresa, $clienteid, $periodo, $tipopago),
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a(Yii::t('app','Edit'),['update','numerorecibo, $estadocuentaid, $empresa, $clienteid, $periodo, $tipopago'=>$numerorecibo, $estadocuentaid, $empresa, $clienteid, $periodo, $tipopago],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($numerorecibo, $estadocuentaid, $empresa, $clienteid, $periodo, $tipopago),
            ]);
        }
    }

    /**
     * Creates a new Recibodetalle model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($numerorecibo)
    {
        $request = Yii::$app->request;   		
        $model = new Recibodetalle();
		$model->empresa = Yii::$app->user->identity->empresa;
		$model->numerorecibo = $numerorecibo;
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
                    'content'=>'<span class="text-success">Crear Recibodetalle realizado</span>',
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
                return $this->redirect(['updatemd', 'numerorecibo' => $model->numerorecibo, 'estadocuentaid' => $model->estadocuentaid, 'empresa' => $model->empresa, 'clienteid' => $model->clienteid, 'periodo' => $model->periodo, 'tipopago' => $model->tipopago]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing Recibodetalle model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $numerorecibo
     * @param integer $estadocuentaid
     * @param string $empresa
     * @param string $clienteid
     * @param string $periodo
     * @param string $tipopago
     * @return mixed
     */
    public function actionUpdate($numerorecibo, $estadocuentaid, $empresa, $clienteid, $periodo, $tipopago)
    {
        $request = Yii::$app->request;  		
        $model = $this->findModel($numerorecibo, $estadocuentaid, $empresa, $clienteid, $periodo, $tipopago);
		if ($model->hasProperty('created_by')) {
            $model->modified_at = date('d-m-Y');
            $model->modified_by = Yii::$app->user->identity->username;
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
                            Html::a(Yii::t('app','Edit'),['update','numerorecibo, $estadocuentaid, $empresa, $clienteid, $periodo, $tipopago'=>$numerorecibo, $estadocuentaid, $empresa, $clienteid, $periodo, $tipopago],['class'=>'btn btn-primary','role'=>'modal-remote'])
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
                return $this->redirect(['view', 'numerorecibo' => $model->numerorecibo, 'estadocuentaid' => $model->estadocuentaid, 'empresa' => $model->empresa, 'clienteid' => $model->clienteid, 'periodo' => $model->periodo, 'tipopago' => $model->tipopago]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     * Delete an existing Recibodetalle model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $numerorecibo
     * @param integer $estadocuentaid
     * @param string $empresa
     * @param string $clienteid
     * @param string $periodo
     * @param string $tipopago
     * @return mixed
     */
    public function actionDelete($numerorecibo, $estadocuentaid, $empresa, $clienteid, $periodo, $tipopago)
    {
        $request = Yii::$app->request;
        $this->findModel($numerorecibo, $estadocuentaid, $empresa, $clienteid, $periodo, $tipopago)->delete();

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
     * Delete multiple existing Recibodetalle model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $numerorecibo
     * @param integer $estadocuentaid
     * @param string $empresa
     * @param string $clienteid
     * @param string $periodo
     * @param string $tipopago
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
     * Finds the Recibodetalle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $numerorecibo
     * @param integer $estadocuentaid
     * @param string $empresa
     * @param string $clienteid
     * @param string $periodo
     * @param string $tipopago
     * @return Recibodetalle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($numerorecibo, $estadocuentaid, $empresa, $clienteid, $periodo, $tipopago)
    {
        if (($model = Recibodetalle::findOne(['numerorecibo' => $numerorecibo, 'estadocuentaid' => $estadocuentaid, 'empresa' => $empresa, 'clienteid' => $clienteid, 'periodo' => $periodo, 'tipopago' => $tipopago])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

/*
*/

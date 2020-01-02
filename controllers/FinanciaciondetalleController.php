<?php

namespace app\controllers;

use Yii;
use yii\base\ErrorException;
use app\models\Financiaciondetalle;
use app\models\FinanciaciondetalleBuscar;
use yii\web\Controller;
use app\models\Buscar;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;
use app\models\Authmanager;
use app\models\Tools;
use yii\helpers\Inflector;
use yii\helpers\ArrayHelper;

/**
 * FinanciaciondetalleController implements the CRUD actions for Financiaciondetalle model.
 */
class FinanciaciondetalleController extends Controller
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
     * Lists all Financiaciondetalle models.
     * @return mixed
     */
    public function actionIndex()
    {    
               
		$searchModel = new FinanciaciondetalleBuscar();
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
     * Displays a single Financiaciondetalle model.
     * @param string $producto
     * @param string $empresa
     * @param string $financiacion
     * @return mixed
     */
    public function actionView($producto, $empresa, $financiacion)
    {   
        $request = Yii::$app->request; 		
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> Yii::t('app',$this->title)."# ".$producto, $empresa, $financiacion,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($producto, $empresa, $financiacion),
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a(Yii::t('app','Edit'),['update','producto, $empresa, $financiacion'=>$producto, $empresa, $financiacion],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($producto, $empresa, $financiacion),
            ]);
        }
    }

    /**
     * Creates a new Financiaciondetalle model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($empresa, $plantv,$financiacion)
    {
        $request = Yii::$app->request;   		
        $model = new Financiaciondetalle();
		$model->empresa = Yii::$app->user->identity->empresa;
		if ($model->hasProperty('created_by')) {
            $model->created_at = date('d-m-Y');
            $model->modified_at = date('d-m-Y');
            $model->created_by = Yii::$app->user->identity->username;
        }
		if(isset($_GET['_pjax']) && !empty($_GET['_pjax'])) {
			return;
		}

        $query = <<<EOF
select distinct p.producto,p.producto
from producto p
left join plandetalle pd on pd.empresa = p.empresa and pd.producto = p.producto
left join financiaciondetalle f on p.empresa = f.empresa and p.producto = f.producto
where p.financiable = true and pd.plan = :plan and pd.empresa = :empresa
  and p.producto not in (select fd.producto from financiaciondetalle fd where fd.financiacion= :financiacion ) ;

EOF;
        $db = Yii::$app->db;
        $prodaux = $db->createCommand($query)->bindValues(['empresa'=>$empresa,
            'plan'=>$plantv,'financiacion'=>$financiacion])->queryAll();

        //$productosFinanciables=[];


        $productosFinanciables = ArrayHelper::map($prodaux, 'producto', 'producto');
        foreach ($prodaux as $fila){
            //array_push($productosFinanciables,['id' => $fila['producto'], 'text' => $fila['producto']]);
        }


        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->financiacion = $financiacion;
            $model->cuotas = 1;
            $model->intereses = 0;



            if($request->isGet){
                return [
                    'title'=> Yii::t('app', "Add")." ".Yii::t('app', $this->title), 
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'plantv' =>$plantv,
                        'productosFinanciables' =>$productosFinanciables
                    ]),
                    'footer'=> Html::button( Yii::t('app', 'Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button( Yii::t('app', 'Save'),['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> Yii::t('app', "Add")." ".Yii::t('app', $this->title), 
                    'content'=>'<span class="text-success">Crear Financiaciondetalle realizado</span>',
                    'footer'=> Html::button(Yii::t('app', 'Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a(Yii::t('app', 'Create More'),['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> Yii::t('app', "Add")." ".Yii::t('app', $this->title),
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'plantv' =>$plantv,
                        'productosFinanciables' =>$productosFinanciables
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
                return $this->redirect(['updatemd', 'producto' => $model->producto, 'empresa' => $model->empresa, 'financiacion' => $model->financiacion]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'plantv' =>$plantv,
                    'productosFinanciables' =>$productosFinanciables
                ]);
            }
        }
       
    }

    /**
     * Updates an existing Financiaciondetalle model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param string $producto
     * @param string $empresa
     * @param string $financiacion
     * @return mixed
     */
    public function actionUpdate($producto, $empresa, $financiacion)
    {
        $request = Yii::$app->request;  		
        $model = $this->findModel($producto, $empresa, $financiacion);
        $productosFinanciables=[];




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
                        'productosFinanciables' =>$productosFinanciables
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
                        'productosFinanciables' =>$productosFinanciables
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a(Yii::t('app','Edit'),['update','producto, $empresa, $financiacion'=>$producto, $empresa, $financiacion],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> Yii::t('app', "Update")." ".Yii::t('app', $this->title),
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'productosFinanciables' =>$productosFinanciables
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
                return $this->redirect(['view', 'producto' => $model->producto, 'empresa' => $model->empresa, 'financiacion' => $model->financiacion]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'productosFinanciables' =>$productosFinanciables
                ]);
            }
        }
    }
    /**
     * Delete an existing Financiaciondetalle model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $producto
     * @param string $empresa
     * @param string $financiacion
     * @return mixed
     */
    public function actionDelete($producto, $empresa, $financiacion)
    {
        $request = Yii::$app->request;
        $this->findModel($producto, $empresa, $financiacion)->delete();

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
     * Delete multiple existing Financiaciondetalle model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $producto
     * @param string $empresa
     * @param string $financiacion
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
     * Finds the Financiaciondetalle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $producto
     * @param string $empresa
     * @param string $financiacion
     * @return Financiaciondetalle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($producto, $empresa, $financiacion)
    {
        if (($model = Financiaciondetalle::findOne(['producto' => $producto, 'empresa' => $empresa, 'financiacion' => $financiacion])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

/*
*/

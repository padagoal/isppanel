<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
use app\models\Authmanager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientesBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;

$modal = "'role'=>'modal-remote',";

if ($title == 'Prospectos') {

    $columns = '/_columns_prospecto.php';
    $content = Authmanager::IndexToolbar($searchModel::tableName(),'create',Yii::$app->user->identity->id,$title,$modal);
}else if ($title == 'Preinstalaciones') {
    $columns = '/_columns_preinstalaciones.php';
    $content = Authmanager::IndexToolbar($searchModel::tableName(),'create',Yii::$app->user->identity->id,$title,$modal,false);
}else if ($title == 'Instalaciones') {
    $columns = '/_columns_instalaciones.php';
    $content = Authmanager::IndexToolbar($searchModel::tableName(),'create',Yii::$app->user->identity->id,$title,$modal,false);
} else {
    $content = Authmanager::IndexToolbar($searchModel::tableName(),'create',Yii::$app->user->identity->id,$title,$modal,false);
    $columns = '/_columns.php';
   // print_r('DEFAULT');
}

CrudAsset::register($this);


?>
<div class="clientes-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.$columns),
            'toolbar'=> [
                ['content'=>$content],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary',
                'heading' => Yii::t('app', 'List of').' '. $title,]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

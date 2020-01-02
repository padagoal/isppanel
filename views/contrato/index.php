<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
use app\models\Authmanager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContratoBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

$modal = "'role'=>'modal-remote',";
$content = Authmanager::IndexToolbar($searchModel::tableName(),'create',Yii::$app->user->identity->id,$title,$modal);

if ($title == 'Preinstalaciones') {
    $columns = '/_columns_preinstalacion.php';
    $content = Authmanager::IndexToolbar($searchModel::tableName(),'create',Yii::$app->user->identity->id,$title,$modal,false);
}else if ($title == 'Instalaciones') {
    $columns = '/_columns.php';
    $content = Authmanager::IndexToolbar($searchModel::tableName(),'create',Yii::$app->user->identity->id,$title,$modal,false);
} else {
    $content = Authmanager::IndexToolbar($searchModel::tableName(),'create',Yii::$app->user->identity->id,$title,$modal,false);
    $columns = '/_columns.php';
    // print_r('DEFAULT');
}
?>
<div class="contrato-index">
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

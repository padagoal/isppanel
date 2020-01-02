<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

CrudAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Serviciocliente */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="serviciocliente-form">

    <?php  $form = ActiveForm::begin([
        'id' => 'form-signup',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]); ?>

    <?= $form->field($model, 'contrato')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tiposervicio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fechasolicitud')->widget(kartik\date\DatePicker::classname(),[
            'options' => ['placeholder' => 'Elija la fecha ...'],
            'language' => 'es',
            'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true
        ]]) ?>

    <?= $form->field($model, 'fecharealizacion')->widget(kartik\date\DatePicker::classname(),[
            'options' => ['placeholder' => 'Elija la fecha ...'],
            'language' => 'es',
            'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true
        ]]) ?>

    <?= $form->field($model, 'realizado')->checkbox() ?>

    <?= $form->field($model, 'callcenter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tecnico')->textInput() ?>

    <?= $form->field($model, 'estado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ubicacion')->textInput() ?>

    <?= $form->field($model, 'observaciones')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fechaasignacion')->widget(kartik\date\DatePicker::classname(),[
            'options' => ['placeholder' => 'Elija la fecha ...'],
            'language' => 'es',
            'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true
        ]]) ?>

    <?= $form->field($model, 'fechareasignacion')->widget(kartik\date\DatePicker::classname(),[
            'options' => ['placeholder' => 'Elija la fecha ...'],
            'language' => 'es',
            'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true
        ]]) ?>

  
<div class="serviciocliente-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/../servicioclientedetalle/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/servicioclientedetalle/create',
					'empresa' => $model->empresa,'contrato' => $model->contrato,'tiposervicio' => $model->tiposervicio,'fechasolicitud' => $model->fechasolicitud,					
					],
                    ['role'=>'modal-remote','title'=> Yii::t('app', 'Create new') . ' Servicioclientes','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>Yii::t('app', 'Reset')]).
                    '{toggleData}'.
                    '{export}'
                ],
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
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
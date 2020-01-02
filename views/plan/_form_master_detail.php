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
/* @var $model app\models\Plan */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="plan-form">

    <?php  $form = ActiveForm::begin([
        'id' => 'form-signup',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]); ?>

    <?= $form->field($model, 'plan')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'estado')->textInput(['maxlength' => true ,'readonly'=>true]) ?>

    <?= $form->field($model, 'monto')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'formaduracion')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'duracion')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'fechainicio')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'fechafin')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'observaciones')->textarea(['rows' => 6,'readonly'=>true]) ?>

  
<div class="plan-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/../plandetalle/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/plandetalle/create',
					'empresa' => $model->empresa,'plan' => $model->plan,					
					],
                    ['role'=>'modal-remote','title'=> Yii::t('app', 'Create new') . ' Plans','class'=>'btn btn-default']).
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
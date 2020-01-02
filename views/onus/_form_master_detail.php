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
/* @var $model app\models\Onus */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="onus-form">

    <?php  $form = ActiveForm::begin([
        'id' => 'form-signup',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]); ?>

    <?= $form->field($model, 'onuid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oltid')->textInput() ?>

    <?= $form->field($model, 'board')->textInput() ?>

    <?= $form->field($model, 'port')->textInput() ?>

    <?= $form->field($model, 'contrato')->textInput(['maxlength' => true]) ?>

  
<div class="onus-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/..//_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['//create',
					'onuid' => $model->onuid,					
					],
                    ['role'=>'modal-remote','title'=> Yii::t('app', 'Create new') . ' Onuses','class'=>'btn btn-default']).
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
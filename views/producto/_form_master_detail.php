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
/* @var $model app\models\Producto */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="producto-form">

    <?php  $form = ActiveForm::begin([
        'id' => 'form-signup',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]); ?>

    <?= $form->field($model, 'producto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'grupo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'precio')->textInput() ?>

    <?= $form->field($model, 'maximo')->textInput() ?>

    <?= $form->field($model, 'ciclico')->checkbox() ?>

    <?= $form->field($model, 'formaciclo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cantidadciclo')->textInput() ?>

    <?= $form->field($model, 'observaciones')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'subgrupoproducto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'financiable')->checkbox() ?>

    <?= $form->field($model, 'puededescuento')->checkbox() ?>

  
<div class="producto-index">
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
					'empresa' => $model->empresa,'producto' => $model->producto,					
					],
                    ['role'=>'modal-remote','title'=> Yii::t('app', 'Create new') . ' Productos','class'=>'btn btn-default']).
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
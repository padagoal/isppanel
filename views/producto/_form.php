<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use app\models\Grupoproductos;
use app\models\Formasciclo;


$grupoproductos = ArrayHelper::map(Grupoproductos::find()->all(), 'grupo', 'grupo');
$formasciclo = ArrayHelper::map(Formasciclo::find()->all(), 'formaciclo', 'formaciclo');

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
    <?= $form->field($model, 'grupo')->dropDownList($grupoproductos) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'precio')->textInput(['type'=>'number']) ?>

    <?= $form->field($model, 'maximo')->textInput(['type'=>'number']) ?>

    <?= $form->field($model, 'ciclico')->checkbox() ?>

    <?= $form->field($model, 'formaciclo')->dropDownList($formasciclo) ?>
    <?= $form->field($model, 'cantidadciclo')->textInput(['type'=>'number']) ?>

    <?= $form->field($model, 'financiable')->checkbox() ?>

    <?= $form->field($model, 'puededescuento')->checkbox() ?>

    <?= $form->field($model, 'observaciones')->textarea(['rows' => 2]) ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

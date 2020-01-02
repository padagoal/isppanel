<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;


use app\models\Contrato;
use app\models\Producto;
use app\models\Periodos;
use app\models\Tipopagos;
use app\models\Factura;
use app\models\Estadopagos;




/* @var $this yii\web\View */
/* @var $model app\models\Estadocuenta */
/* @var $form yii\widgets\ActiveForm */




?>

<div class="estadocuenta-form">

    <?php  $form = ActiveForm::begin([
        'id' => 'form-signup',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]); ?>

    <?= $form->field($model, 'contrato')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'producto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fechainicio')->widget(kartik\date\DatePicker::classname(),[
            'options' => ['placeholder' => 'Elija la fecha ...'],
            'language' => 'es',
            'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true
        ]]) ?>

    <?= $form->field($model, 'periodo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipopago')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'numerofactura')->textInput() ?>

    <?= $form->field($model, 'vencimiento')->widget(kartik\date\DatePicker::classname(),[
            'options' => ['placeholder' => 'Elija la fecha ...'],
            'language' => 'es',
            'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true
        ]]) ?>

    <?= $form->field($model, 'estadopago')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'monto')->textInput() ?>

    <?= $form->field($model, 'numerorecibo')->textInput() ?>

  
  <?php   if (!Yii::$app->request->isAjax){ ?>
	<div class="form-group highlight-addon">
        <label class="control-label has-star col-sm-4" for="plan-observaciones"></label>
        <div class="col-sm-11">
        </div>
        <div class="col-sm-1 pull-right" >           
                <div class="form-group" >
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            
        </div>
    </div>
  <?php }	?> 

    <?php ActiveForm::end(); ?>
    
</div>

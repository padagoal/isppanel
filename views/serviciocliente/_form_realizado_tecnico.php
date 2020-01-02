<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Url;
use kartik\select2\Select2;

use app\models\User;
use app\models\Estadoservicios;
use app\models\Tiposervicios;

/* @var $this yii\web\View */
/* @var $model app\models\Serviciocliente */
/* @var $form yii\widgets\ActiveForm */

$tecnicos = ArrayHelper::map(User::find()->where(['profile'=>'Tecnico','empresa'=>Yii::$app->user->identity->empresa])->all(), 'id', 'username');

$estadosServicios = ArrayHelper::map(Estadoservicios::find()->all(), 'estado', 'estado');

$tipoServicios = ArrayHelper::map(Tiposervicios::find()->all(), 'tiposervicio', 'tiposervicio');


?>

<div class="serviciocliente-form">

    <?php  $form = ActiveForm::begin([
        'id' => 'form-signup',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]); ?>


    <div class="container-fluid">
        <div class="row row-eq-height">
            <div class="col-xs-12 col-md-6">
                <div class="panel panel-primary">
                    <!-- Default panel contents -->
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-user"></i>
                        Datos para Asignacion
                    </div>

                    <ul class="list-group">
                        <li class="list-group-item">
                            <?= $form->field($model, 'contrato')->textInput(['maxlength' => true,'readonly'=>true]) ?>
                        </li>
                        <li class="list-group-item">
                            <?= $form->field($model, 'fechasolicitud')->textInput(['maxlength' => true,'readonly'=>true]) ?>
                        </li>
                        <li class="list-group-item">
                            <?= $form->field($model, 'tiposervicio')->textInput(['maxlength' => true,'readonly'=>true]) ?>
                        </li>
                        <li class="list-group-item">
                            <?= $form->field($model, 'callcenter')->textInput(['maxlength' => true]) ?>

                        </li>
                        <li class="list-group-item">
                            <?= $form->field($model, 'fechaasignacion')->textInput(['maxlength' => true,'readonly'=>true]) ?>
                        </li>

                    </ul>
                </div>
            </div>


            <!-------->

            <div class="col-xs-12 col-md-6">
                <div class="panel panel-primary">
                    <!-- Default panel contents -->
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-user"></i>
                        Datos Extra del Trabajo
                    </div>

                    <ul class="list-group">
                        <li class="list-group-item">
                            <?= $form->field($model, 'ubicacion')->textInput(['maxlength' => true,'readonly'=>true]) ?>

                        </li>
                        <li class="list-group-item">
                            <?= $form->field($model, 'estado')->dropdownlist($estadosServicios) ?>
                        </li>
                        <li class="list-group-item">
                            <?= $form->field($model, 'observaciones')->textarea(['rows' => 6]) ?>
                        </li>
                        <li class="list-group-item">
                            <?= $form->field($model, 'realizado')->checkbox() ?>
                        </li>
                        <li class="list-group-item">
                            <div id="fecharealizado">
                                <?= $form->field($model, 'fecharealizacion')->widget(kartik\date\DatePicker::classname(),[
                                    'options' => ['placeholder' => 'Elija la fecha ...'],
                                    'language' => 'es',
                                    'pluginOptions' => [
                                        'format' => 'dd-mm-yyyy',
                                        'todayHighlight' => true
                                    ]]) ?>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>


        </div>
    </div>

    <div class="container-fluid">
        <div class="row row-eq-height">
            <div class="col-xs-12 col-md-6">
                <div id="mensaje-disponibilidad">

                </div>
            </div>
        </div>
    </div>


<?php

$this->registerJs(
    "
        function verificarDisponibilidad(){
        
            var datoTecnico = $('#serviciocliente-tecnico').val();
            
            
            if(datoTecnico!= ''){
                var datos = {
                    tecnico : $('#serviciocliente-tecnico').val(), 
                }
            
                $.post('".Yii::$app->urlManager->createUrl('serviciocliente/checkdisponibilidad')."',
                    {
                       tecni: datos ,
                    },
                    function( data ) {                       
                    document.getElementById('mensaje-disponibilidad').innerHTML = data;
                 });
            }else{
                document.getElementById('mensaje-disponibilidad').innerHTML = '';
            }
            
        
        }
    
    
    
    
         ",
        View::POS_END
    );?>


  
  <?php   if (!Yii::$app->request->isAjax){ ?>
	<div class="form-group highlight-addon">
        <label class="control-label has-star col-sm-4" for="plan-observaciones"></label>
        <div class="col-sm-11 hidden-xs">
        </div>
        <div class="col-sm-1 col-xs-12 pull-right" >
                <div class="form-group" >
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            
        </div>
    </div>
  <?php }	?> 

    <?php ActiveForm::end(); ?>
    
</div>

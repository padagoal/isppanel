<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\depdrop\DepDrop;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Url;

use app\models\User;
use app\models\Plan;
use app\models\Promocion;
use app\models\Financiacion;
use app\models\Clientes;
use app\models\Modalidades;

$vendedores = ArrayHelper::map(User::find()->where(['profile'=>'Vendedor','empresa'=>Yii::$app->user->identity->empresa])->all(), 'id', 'username');
$plan = ArrayHelper::map(Plan::find()->where(['empresa'=>Yii::$app->user->identity->empresa,'estado'=>'Activo'])->all(), 'plan', 'plan');
$promocion = ArrayHelper::map(Promocion::find()->where(['empresa'=>Yii::$app->user->identity->empresa,'estado'=>'Activo'])->all(), 'promocion', 'promocion');
$financiacion = ArrayHelper::map(Financiacion::find()->where(['empresa'=>Yii::$app->user->identity->empresa,'estado'=>'Activo'])->all(), 'financiacion', 'financiacion');
$cliente = ArrayHelper::map(Clientes::find()->where(['empresa'=>Yii::$app->user->identity->empresa,'clienteid'=>$model->clienteid])->all(), 'clienteid', 'cliente');
$modalidades = ArrayHelper::map(Modalidades::find()->all(), 'modalidad', 'modalidad');

/* @var $this yii\web\View */
/* @var $model app\models\Contrato */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="contrato-form">
    <?php yii\widgets\Pjax::begin(); ?>
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
                            Contratos - Datos Cliente - Vendedor
                        </div>

                            <ul class="list-group">
                                <li class="list-group-item">
                                    <?= $form->field($model, 'contrato')->textInput(['maxlength' => true,
                                        'readonly' => 'true']) ?>
                                </li>
                                <li class="list-group-item">
                                    <?= $form->field($model, 'clienteid')->textInput(['maxlength' => true,
                                        'readonly' => 'true']) ?>
                                </li>
                                <li class="list-group-item">
                                    <?= $form->field($model, 'vendedor')->textInput(['maxlength' => true,
                                        'readonly' => 'true']) ?>
                                </li>

                                <li class="list-group-item"> <!--style="margin-bottom: 40px;-->
                                    <?= $form->field($model, 'observaciones')->textarea(['rows' => 3]) ?>
                                </li>
                                <li class="list-group-item">
                                    <?= $form->field($model, 'estado')->textInput(['maxlength' => true,
                                        'readonly' => 'true']) ?>
                                </li>
                                <li class="list-group-item">
                                    <?= $form->field($model, 'fechainstalacion')->textInput(['maxlength' => true,
                                        'readonly' => 'true']) ?>
                                </li>
                            </ul>
                    </div>
                </div>

            <div class="col-xs-12 col-md-6">
                <div class="panel panel-primary">
                    <!-- Default panel contents -->
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-briefcase"></i>
                        Contratos - Planes - Promociones - Financiacion
                    </div>

                    <ul class="list-group">
                        <li class="list-group-item">
                            <?= $form->field($model, 'plan')->textInput(['maxlength' => true,
                                'readonly' => 'true']) ?>
                        </li>
                        <li class="list-group-item">
                            <?=$form->field($model, 'promocion')->textInput(['maxlength' => true,
                                'readonly' => 'true']) ?>
                        </li>
                        <li class="list-group-item">
                            <?=$form->field($model, 'financiacion')->textInput(['maxlength' => true,
                                'readonly' => 'true']) ?>
                        </li>

                        <li class="list-group-item">
                            <?= $form->field($model, 'fechainicio')->textInput(['maxlength' => true,
                                'readonly' => 'true'])?>
                        </li>
                        <li class="list-group-item">
                            <?= $form->field($model, 'modalidad')->textInput(['maxlength' => true,
                                'readonly' => 'true']) ?>
                        </li>
                        <li class="list-group-item">
                            <?= $form->field($model, 'equipos')->textInput(['maxlength' => true,
                                'readonly' => 'true']) ?>
                        </li>
                        <li class="list-group-item">
                            <?= $form->field($model, 'duracion')->textInput(['maxlength' => true,
                                'readonly' => 'true']) ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <style>
        #loading{
            width: 50%;
            margin-left: 25%;
            margin-bottom: 1em;
        }
    </style>


    <div class="container-fluid">
        <div class="row row-eq-height">
            <div class="col-xs-12 col-md-6">
                <input type="button" id ="vistaprevia" name="vistaprevia" class="btn btn-info"
                       value="Visualizar Estado Cuenta">
                <div id="loading">
                    <img src="/img/gif/loading_rolling.gif" width="5%">
                    <span>
            <label for ="loading">Generando Resumen<labe>
        </span>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <input type="button" id ="cambioEstado" name="cambioEstado" class="btn btn-success"
                       value="Confirmar la Venta">

            </div>
        </div>
    </div>






    <?= $form->field($model, 'diavto')->hiddenInput(['value'=>10])->label(false); ?>

    <?php
    //Sin Promocion es en español... hay que ver el valor interno dentro de la tabla promociones
    $this->registerJs(
        "
                
        $(window).ready(hideLoader);
        function hideLoader() {
           $('#loading').hide();
        }     
        function showLoader() {
           $('#loading').show();
        }       
                ",
        View::POS_READY
    );?>




    <?php
    //Sin Promocion es en español... hay que ver el valor interno dentro de la tabla promociones
    $this->registerJs(
        "
        
        $('#vistaprevia').click(function(e){
            e.preventDefault();
                    
                    if($(\"#contrato-plan\").val() != '' && $(\"#contrato-promocion\").val() != '' 
                        && $(\"#contrato-financiacion\").val() != '' ){
                         $('#loading').show();
                        var datos = {
                                        contrato:$('#contrato-contrato').val(), 
                                        clienteid:$(\"#contrato-clienteid\").val(), 
                                        vendedor:$(\"#contrato-vendedor\").val(), 
                                        plan:$(\"#contrato-plan\").val(),
                                        promocion:$(\"#contrato-promocion\").val(),
                                        financiacion:$(\"#contrato-financiacion\").val(),
                                        fechainicio:$(\"#contrato-fechainicio\").val(),
                                        equipos:$(\"#contrato-equipos\").val(),
                                        obs:$(\"#contrato-observaciones\").val(),
                                        duracion:$(\"#contrato-duracion\").val(),
                                        diavto: $(\"#contrato-diavto\").val(),
                                        modalidad: $(\"#contrato-modalidad\").val(),
                                    };
                        
                            console.log(datos);
                            $.post('".Yii::$app->urlManager->createUrl('contrato/generardetallecontrato')."',
                                    {aux : datos },
                                    function( data ) {
                                       $('#loading').hide();
                                        document.getElementById('estadocuenta').innerHTML = data;
                                        console.log(data);               
                            });
                    } else{
                        alert('Falta datos para la generacion del contrato');
                    }  
        });
        
        $('#cambioEstado').click(function(e){
            e.preventDefault();
                    
                    if($(\"#contrato-plan\").val() != '' && $(\"#contrato-promocion\").val() != '' 
                        && $(\"#contrato-financiacion\").val() != '' ){
                         
                        var datos = {
                                        contrato:$('#contrato-contrato').val(), 
                                        clienteid:$(\"#contrato-clienteid\").val(), 
                                       
                                    };
                        
                            console.log(datos);
                            $.post('".Yii::$app->urlManager->createUrl('contrato/manejoestado')."',
                                    {info : datos },
                                    function( data ) {
                                       $('#loading').hide();
                                        alert(data);
                                        console.log(data);               
                                        window.location.href = data;
                            });
                    } else{
                        alert('Falta datos para la generacion del contrato');
                    }  
        });
                ",
        View::POS_END
    );?>



<br>


<div id="estadocuenta" >

</div>

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
    <?php yii\widgets\Pjax::end(); ?>
</div>

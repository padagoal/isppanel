<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use app\controllers\ReciboController;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Recibo */
/* @var $form yii\widgets\ActiveForm */

use app\models\Clientes;
use app\models\Estadopagos;
use app\models\User;

$cliente = ArrayHelper::map(Clientes::find()->where(['empresa'=>Yii::$app->user->identity->empresa])->all(), 'clienteid', 'cliente');
$estadopago = ArrayHelper::map(Estadopagos::find()->all(), 'estadopago', 'estadopago');
$cobradores = ArrayHelper::map(User::find()->where(['profile'=>'Cobrador','empresa'=>Yii::$app->user->identity->empresa])->all(), 'id', 'username');
?>

<div class="recibo-form">

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
                        <i class="glyphicon glyphicon-usd"></i>
                        Datos Recibo
                    </div>

                    <ul class="list-group">
                        <li class="list-group-item">
                            <?= $form->field($model, 'numero')->textInput(['readonly'=>true]) ?>
                        </li>
                        <li class="list-group-item">
                            <?= $form->field($model, 'clienteid')->dropDownList($cliente,['readonly'=>true,'disabled'=>true]) ?>
                        </li>
                        <li class="list-group-item">
                            <?= $form->field($model, 'estadopago')->dropdownlist($estadopago) ?>
                        </li>
                        <li class="list-group-item">
                            <?= $form->field($model, 'cobrador')->dropdownlist($cobradores) ?>
                        </li>
                        <li class="list-group-item">
                            <?= $form->field($model, 'fechaemision')->widget(kartik\date\DatePicker::classname(),[
                                'options' => ['placeholder' => 'Elija la fecha ...'],
                                'language' => 'es',
                                'pluginOptions' => [
                                    'format' => 'dd-mm-yyyy',
                                    'todayHighlight' => true
                                ]]) ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div id="container-preinstalacion">

                    <?php
                    print ReciboController::datosParaPagarPreinstalacion($model->empresa,$model->clienteid,$contrato);
                    ?>
                </div>
                <div id="container-ultimopago">
                    <?php
                    print ReciboController::generarUltimoPago($model->clienteid,$contrato);
                        ?>
                </div>

                    <div class="row row-eq-height">
                        <div class="col-xs-12 col-md-12">
                            <div class="panel panel-success">
                                <!-- Default panel contents -->
                                <div class="panel-heading">
                                    <i class="glyphicon glyphicon-usd"></i>
                                    Pago de Cuotas
                                </div>
                                <ul class="list-group">
                                    <li class="list-group-item">

                                        <label for="monthforpaid"> Cantidad de Cuotas a Pagar</label>
                                        <input type="number" min="1" id="monthforpaid" name="monthforpaid" value="1" / >
                                        <input type="button" id ="genmonths" name="genmonths" class="btn btn-success"
                                               value="Generar los pagos" />
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                <div id="mensajes-sistema">

                </div>
            </div>
        </div>
    </div>







    <input type="hidden" id="contrato" name="contrato" value="<?=$contrato?>"/>
    <input type="hidden" id="empresa" name="empresa" value="<?=$model->empresa?>"/>





    <br>

    <br>
    <div id="container-months-paid">

    </div>
    <br>
<div class="container-fluid">
    <div id="container-months">

    </div>
</div>





    <?php

    $this->registerJs(
        "
        
        $('#paidpre').click(function(e){
            e.preventDefault();
                    var datos = {
                                        contrato:$('#contrato').val(), 
                                        empresa:$('#empresa').val(), 
                                        clienteid:$(\"#recibo-clienteid\").val(), 
                                        numero:$(\"#recibo-numero\").val(), 
                                        cobrador:$(\"#recibo-cobrador\").val(), 
                                        fechaemision:$(\"#recibo-fechaemision\").val(), 
                                       
                                    };
                    $.post('".Yii::$app->urlManager->createUrl('recibo/paidpre')."',
                                    {info : datos },
                                    function( data ) {
                                       document.getElementById('mensajes-sistema').innerHTML = data; 
                                       checkPre();
                                       ultimoPago();
                            });
        });
        
         $('#genmonths').click(function(e){
            e.preventDefault();
                    genM();
        });
        
        function genM(){
            var months = {
                                        contrato:$('#contrato').val(), 
                                        empresa:$('#empresa').val(), 
                                        clienteid:$(\"#recibo-clienteid\").val(), 
                                        cantMeses:$('#monthforpaid').val(),
                                       
                                    };
                    console.log(months);
                    $.post('".Yii::$app->urlManager->createUrl('recibo/generatemonths')."',
                                        {asset : months },
                                    function( data ) {
                                       
                                        document.getElementById('container-months').innerHTML = data;
                                                    
                                       
                            });
        }
        function testeP(){
             var paidM = {
                                        estados:document.getElementById('paidMonths').title, 
                                        contrato:$('#contrato').val(), 
                                        empresa:$('#empresa').val(), 
                                        clienteid:$(\"#recibo-clienteid\").val(),
                                         numero:$(\"#recibo-numero\").val(), 
                                        cobrador:$(\"#recibo-cobrador\").val(), 
                                        fechaemision:$(\"#recibo-fechaemision\").val(), 
                                        
                                        
                                       
                                       
                                    };
                                    
               $.post('".Yii::$app->urlManager->createUrl('recibo/paidmonthsselected')."',
                                        {paidM : paidM },
                                    function( data ) {
                                        document.getElementById('mensajes-sistema').innerHTML = data;
                                        document.getElementById('container-months').innerHTML = '';
                                        checkPre();
                                        ultimoPago();
                                        
                            });
               
        }
         
        function ultimoPago(){
        
            var lastpaid = {
                                        contrato:$('#contrato').val(), 
                                        clienteid:$(\"#recibo-clienteid\").val(),
                                                
                               };
            $.post('".Yii::$app->urlManager->createUrl('recibo/lastpaid')."',
                                        {
                                            lastpaid : lastpaid 
                                        },
                                    function( data ) {
                                        document.getElementById('container-ultimopago').innerHTML = data;
                                        
                                        
                            });
        }
        
        function checkPre(){
        
            var checkPre = {
                                        empresa:$('#empresa').val(), 
                                        contrato:$('#contrato').val(), 
                                        clienteid:$(\"#recibo-clienteid\").val(),
                                                
                               };
            $.post('".Yii::$app->urlManager->createUrl('recibo/checkpreinstalacion')."',
                                        {
                                            checkPre : checkPre 
                                        },
                                    function( data ) {
                                        document.getElementById('container-preinstalacion').innerHTML = data;     
                            });
        }
        
                ",
        View::POS_END
    );?>
  <?php   if (!Yii::$app->request->isAjax){ ?>
	<div class="form-group highlight-addon">
        <label class="control-label has-star col-sm-4" for="plan-observaciones"></label>
        <div class="col-md-11 hidden-sm hidden-xs">
        </div>
        <div class="col-md-1 col-sm-12 col-xs-12 pull-right" >
                <div class="form-group" >
                    <center>
                        <input type="button" id ="ready" name="ready" class="btn btn-success"
                           value="Listo" onclick="window.location.href='/recibo'" style="width: 75%"/>
                    </center>
                </div>
            
        </div>
    </div>
  <?php }	?> 

    <?php ActiveForm::end(); ?>
    
</div>

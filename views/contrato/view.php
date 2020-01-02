<?php

use yii\widgets\DetailView;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Url;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Contrato */
?>
<?php yii\widgets\Pjax::begin(); ?>
<?php  $form = ActiveForm::begin([
    'id' => 'form-signup',
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
]); ?>
<div class="contrato-view">
 


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
                            <?= $form->field($model, 'clienteid')->textInput(['maxlength' => true,
                                'readonly' => 'true']) ?>
                        </li>
                        <li class="list-group-item">
                            <?= $form->field($model, 'vendedor')->textInput(['maxlength' => true,
                                'readonly' => 'true']) ?>
                        </li>
                        <li class="list-group-item" style="margin-bottom: 40px;">
                            <?= $form->field($model, 'observaciones')->textarea(['rows' => 7,'readonly'=>'true']) ?>
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

                            <?= $form->field($model, 'modalidad')->textInput(['maxlength' => true,
                                'readonly' => 'true']) ?>
                        </li>
                        <li class="list-group-item">

                            <?=$form->field($model, 'plan')->textInput(['maxlength' => true,
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

    <div class="container-fluid">
        <div class="row row-eq-height">
            <div class="col-xs-12 col-md-6">
                <input type="button" id ="vistaprevia" name="vistaprevia" class="btn btn-info"
                       value="Gestionar Pagos">
            </div>
        </div>
    </div>
<?php
    $this->registerJs(
    "

    $('#vistaprevia').click(function(e){
    
     window.location = '".Yii::$app->urlManager->createUrl('recibo/pagar')."?empresa=".$model->empresa."&clienteid=".
    $model->clienteid."&contrato=".$model->contrato." ';
    });
    ",
    View::POS_END
    );?>



    <?php ActiveForm::end(); ?>
    <?php yii\widgets\Pjax::end(); ?>



</div>

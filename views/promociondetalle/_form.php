<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Promociondetalle */
/* @var $form yii\widgets\ActiveForm */

use app\models\Producto;
use app\models\Estadopromos;
use app\models\Plan;
use app\models\Formasdescuento;
use app\models\Promodisponible;

$Productos = ArrayHelper::map(\app\models\Plandetalle::find()->where(['empresa'=>$model->empresa , 'plan'=>$model->plan])->all(), 'producto', 'producto');

$estadopromo = ArrayHelper::map(Estadopromos::find()->all(), 'estado', 'estado');

$preselpromodisponible = ArrayHelper::map(Promodisponible::find()->where(['empresa'=>$model->empresa , 'promocion'=>$model->promocion])->all(), 'plan', 'plan');

$planes = ArrayHelper::map(Plan::find()->where(['in', 'plan', $preselpromodisponible])->all(), 'plan', 'plan');
//$planes = ArrayHelper::map(Plan::find()->where(['estado'=>'Activo'])->all(), 'plan', 'plan');

$formasdesc = ArrayHelper::map(Formasdescuento::find()->all(), 'formadescuento', 'formadescuento');

?>

<div class="promociondetalle-form">

    <?php  $form = ActiveForm::begin([
        'id' => 'form-signup',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]); ?>

    <?= $form->field($model, 'promocion')->textInput(['maxlength' => true,'readonly'=> true]) ?>

    <?= $form->field($model, 'plan')->textInput(['maxlength' => true,'readonly'=> true]) ?>

    <?php
    if($isUpdate){
        ?>
        <?= $form->field($model, 'producto')->textInput(['maxlength' => true,'readonly'=> true]) ?>
    <?php    }else{

        ?>
        <?= $form->field($model, 'producto')->widget(Select2::className(),[
            'data' => $productosPromocionables,
            'options' => [
                'placeholder' => Yii::t('app', 'selProd'),
                'multiple'=>false,
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

        <?php
    }

    ?>








    <?= $form->field($model, 'formadescuento')->dropdownlist($formasdesc) ?>

    <?= $form->field($model, 'cuotas')->textInput(['type'=>'number']) ?>

    <?= $form->field($model, 'descuento')->textInput() ?>

    <?= $form->field($model, 'observaciones')->textarea(['rows' => 6]) ?>

  
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

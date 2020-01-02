<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use dosamigos\multiselect\MultiSelect;


use app\models\Plan;
use app\models\Promodisponible;
/* @var $this yii\web\View */
/* @var $model app\models\Promodisponible */
/* @var $form yii\widgets\ActiveForm */


$presel = ArrayHelper::map(Promodisponible::find()->where(['empresa'=>$model->empresa , 'promocion'=>$model->promocion])->all(), 'plan', 'plan');
$plan = ArrayHelper::map(Plan::find()->where(['not in', 'plan', $presel])->all(), 'plan', 'plan');


?>



<div class="promodisponible-form">

    <?php  $form = ActiveForm::begin([
        'id' => 'form-signup',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]); ?>

    <?= $form->field($model, 'promocion')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'plan[]')->widget(MultiSelect::className(),[
        'data' => $plan,
        "options" => ['multiple'=>true],
    ]) ?>

  
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

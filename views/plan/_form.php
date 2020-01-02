<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use app\models\Estadoplan;
use app\models\Formasduracion;
use app\models\Modalidades;

$Estadoplan = ArrayHelper::map(Estadoplan::find()->all(), 'estado', 'estado');
$Formasduracion = ArrayHelper::map(Formasduracion::find()->all(), 'formaduracion', 'formaduracion');
$modalidades = ArrayHelper::map(Modalidades::find()->all(), 'modalidad', 'modalidad');

/* @var $this yii\web\View */
/* @var $model app\models\Plan */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="plan-form">

    <?php  $form = ActiveForm::begin([
        'id' => 'form-signup',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]); ?>

    <?= $form->field($model, 'plan')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'estado')->dropDownList($Estadoplan) ?>

    <?= $form->field($model, 'monto')->textInput() ?>
    <?= $form->field($model, 'formaduracion')->dropDownList($Formasduracion) ?>

    <?= $form->field($model, 'modalidad')->dropdownlist($modalidades) ?>

    <?= $form->field($model, 'duracion')->textInput(['type'=>'number']) ?>

    <?= $form->field($model, 'fechainicio')->widget(kartik\date\DatePicker::classname(),[
            'options' => ['placeholder' => 'Elija la fecha ...'],
            'language' => 'es',
            'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true
        ]]) ?>

    <?= $form->field($model, 'fechafin')->widget(kartik\date\DatePicker::classname(),[
            'options' => ['placeholder' => 'Elija la fecha ...'],
            'language' => 'es',
            'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true
        ]]) ?>

    <?= $form->field($model, 'observaciones')->textarea(['rows' => 6]) ?>


    <div class="form-group highlight-addon">
        <label class="control-label has-star col-sm-4" for="plan-observaciones"></label>
        <div class="col-sm-11">
        </div>
        <div class="col-sm-1 pull-right" >
            <?php if (!Yii::$app->request->isAjax){ ?>
                <div class="form-group" >
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            <?php } ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>
    
</div>

<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use app\models\Zonas;
use app\models\User;

$Zonas = ArrayHelper::map(Zonas::find()->all(), 'zona', 'zona');
$vendedores = ArrayHelper::map(User::find()->where(['profile'=>'Vendedor'])->all(), 'id', 'username');

/* @var $this yii\web\View */
/* @var $model app\models\Clientes */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="clientes-form">

    <?php  $form = ActiveForm::begin([
        'id' => 'form-signup',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]); ?>

    <!--?= $form->field($model, 'clienteid')->textInput(['maxlength' => true]) ?-->
    <?= $form->field($model, 'cedula')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'cliente')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'zona')->dropDownList($Zonas) ?>

    <?= $form->field($model, 'celular')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'whatsapp')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'vendedor')->dropDownList($vendedores) ?>

    <?= $form->field($model, 'fechainicio')->widget(kartik\date\DatePicker::classname(),[
            'options' => ['placeholder' => 'Elija la fecha ...'],
            'language' => 'es',
            'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true
        ]]) ?>

    <?php if($model->estado !== 'Prospecto') {
        $form->field($model, 'contrato')->textInput(['maxlength' => true]);

        $form->field($model, 'fechacontrato')->widget(kartik\date\DatePicker::classname(), [
            'options' => ['placeholder' => 'Elija la fecha ...'],
            'language' => 'es',
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true
            ]]);
        $form->field($model, 'localizacion')->textInput(['maxlength' => true]);
        $form->field($model, 'lat')->textInput(['maxlength' => true]);
        $form->field($model, 'lon')->textInput(['maxlength' => true]);
        $form->field($model, 'diadecorte')->textInput();

        $form->field($model, 'callcenter')->textInput();



        $form->field($model, 'monto')->textInput();

        $form->field($model, 'nir')->textInput(['maxlength' => true]);

        $form->field($model, 'ccc')->textInput(['maxlength' => true]);
    }?>

    <?= $form->field($model, 'observaciones')->textarea(['rows' => 2]) ?>

  
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

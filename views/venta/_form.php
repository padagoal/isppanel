<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\datetime\DateTimePicker;
use app\models\Planestv;
use app\models\Planesinternet;
use app\models\Descuentostv;
use app\models\Descuentosinternet;
use app\models\Promociones;

/* @var $this yii\web\View */
/* @var $model app\models\Venta */
/* @var $form yii\widgets\ActiveForm */

$empresa = Yii::$app->user->identity->empresa;

$plantv = ArrayHelper::map(Planestv::find()->where(['empresa' => $empresa])->all(), 'plantv', 'plantv');
$dctoplan = ArrayHelper::map(Descuentostv::find()->where(['empresa' => $empresa])->all(), 'descuentotv', 'descuentotv');
$planinternet = ArrayHelper::map(Planesinternet::find()->where(['empresa' => $empresa])->all(), 'planinternet', 'planinternet');
$dctointernet = ArrayHelper::map(Descuentosinternet::find()->where(['empresa' => $empresa])->all(), 'descuentointernet', 'descuentointernet');
$promociones = ArrayHelper::map(Promociones::find()->where(['empresa' => $empresa])->all(), 'promocion', 'promocion');

?>

<div class="venta-form">

    <?php  $form = ActiveForm::begin([
        'id' => 'form-signup',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]); ?>

    <!--?= $form->field($model, 'ventaid')->textInput(['maxlength' => true]) ?-->

    <!--?= $form->field($model, 'vendedor')->textInput() ?-->

    <!--?= $form->field($model, 'clienteid')->textInput(['maxlength' => true]) ?-->

    <div class="form-group highlight-addon field-venta-clienteid required">
        <label class="control-label has-star col-sm-3" for="venta-clienteid-nombre">Cliente</label>
        <div class="col-sm-9">
            <?= Html::textInput('cliente',$cliente,array('class'=>'form-control','readonly'=> true)) ?>
        </div>
    </div>
    <!--?= $form->field($model, 'estado')->textInput(['maxlength' => true]) ?-->

    <?= $form->field($model, 'promocion')->dropDownList($promociones) ?>

    <?= $form->field($model, 'plantv')->dropDownList($plantv) ?>
    <?= $form->field($model, 'descuentotv')->dropDownList($dctoplan) ?>

    <?= $form->field($model, 'equipostv')->textInput(['type'=>'number']) ?>

    <?= $form->field($model, 'packsadicionales')->textInput() ?>

    <?= $form->field($model, 'planinternet')->dropDownList($planinternet) ?>
    <?= $form->field($model, 'descuentointernet')->dropDownList($dctointernet) ?>

    <!--?= $form->field($model, 'fechaventa')->widget(kartik\date\DatePicker::classname(),[
            'options' => ['placeholder' => 'Elija la fecha ...'],
            'language' => 'es',
            'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true
        ]]) ?-->

    <?= $form->field($model, 'montomensual')->textInput() ?>
    <?= $form->field($model, 'montoinstalacion')->textInput() ?>
    <?= $form->field($model, 'montodescuentos')->textInput() ?>
    <!--?= $form->field($model, 'parametroscobro')->textInput() ?-->
    <?= $form->field($model, 'observaciones')->textarea(['rows' => 6]) ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

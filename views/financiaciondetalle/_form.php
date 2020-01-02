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
/* @var $model app\models\Financiaciondetalle */
/* @var $form yii\widgets\ActiveForm */

use app\models\Producto;
use app\models\Plandetalle;


//$Productos = ArrayHelper::map(Plandetalle::find()->where(['plan'=>$plantv])->all(), 'producto', 'producto');
//$estees = array_values($productosFinanciables);

//print_r($Productos);
//print_r(' ============================ ');
//print_r(array_values($productosFinanciables));
?>

<div class="financiaciondetalle-form">

    <?php  $form = ActiveForm::begin([
        'id' => 'form-signup',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]); ?>
    <?= $form->field($model, 'financiacion')->textInput(['maxlength' => true,'readonly'=> true]) ?>

    <?php
        if($isUpdate){
            ?>
            <?= $form->field($model, 'producto')->textInput(['maxlength' => true,'readonly'=> true]) ?>
        <?php    }else{

            ?>
            <?= $form->field($model, 'producto')->widget(Select2::className(),[
                'data' => $productosFinanciables,
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


    <?= $form->field($model, 'cuotas')->textInput(['type'=>'number']) ?>

    <?= $form->field($model, 'intereses')->textInput(['type'=>'number']) ?>

    <?= $form->field($model, 'observaciones')->textarea(['rows' => 6]) ?>

  
  <?php   if (!Yii::$app->request->isAjax){ ?>
	<div class="form-group highlight-addon">
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

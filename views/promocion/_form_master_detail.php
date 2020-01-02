<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

CrudAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Promocion */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="promocion-form">

    <?php  $form = ActiveForm::begin([
        'id' => 'form-signup',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]); ?>

    <?= $form->field($model, 'promocion')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'estado')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'fechadesde')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'fechahasta')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'observaciones')->textInput(['maxlength' => true,'readonly'=>true]) ?>


    <div class="promociondisponible-index">
        <div id="ajaxCrudDatatable">
            <?=GridView::widget([
                'id'=>'crud-datatable',
                'dataProvider' => $dataProvider2,
                //'filterModel' => $searchModel,
                'pjax'=>true,
                'columns' => require(__DIR__.'/../promodisponible/_columns.php'),
                'toolbar'=> [
                    ['content'=>
                        Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/promodisponible/create',
                            'empresa' => $model->empresa,'promocion' => $model->promocion,
                        ],
                            ['role'=>'modal-remote','title'=> Yii::t('app', 'Create new') . ' Promocions','class'=>'btn btn-default']).
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                            ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>Yii::t('app', 'Reset')]).
                        '{toggleData}'.
                        '{export}'
                    ],
                ],
                'striped' => true,
                'condensed' => true,
                'responsive' => true,

                'panel' => [
                    'type' => 'primary',
                    'heading' => Yii::t('app', 'List of').' '. 'Promo disponible',]
            ])?>
        </div>
    </div>


  


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
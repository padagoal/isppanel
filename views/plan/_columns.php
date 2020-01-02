<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Authmanager;
$template = Authmanager::ColumnsToolbar($searchModel::tableName(),Yii::$app->user->identity->id);

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'empresa',
		   
    ], */
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'plan',
		   
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'estado',
		   
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'monto',
		  'hAlign'=>'right', 'format'=>['decimal',Yii::$app->params['decimals']], 
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'formaduracion',
		   
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'duracion',
		  'hAlign'=>'right', 'format'=>['decimal',Yii::$app->params['decimals']], 
    ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fechainicio',
		  'width' => '80px',
'format' => ['date', 'php:d-m-Y'], 
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fechafin',
		  'width' => '80px',
'format' => ['date', 'php:d-m-Y'], 
    ],*/
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'interno',
		  'format' => 'html',
'width' => '30px',					
'value' => function ($model) {
            if ($model->ENABLED) {
                return Html::a ( '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ');
            } else {
                return Html::a ( ' ');
            }
        }, 
    ], */
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'orden',
		  'hAlign'=>'right', 'format'=>['decimal',Yii::$app->params['decimals']], 
    ], */
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'created_by',
		   
    ], */
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'created_at',
		  'width' => '80px',
'format' => ['date', 'php:d-m-Y'], 
    ], */
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'modified_by',
		   
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'modified_at',
		  'width' => '80px',
'format' => ['date', 'php:d-m-Y'], 
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'observaciones',
		   
    ],*/
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width' => '120px',
        'template' => $template,
		 'buttons' => [
            'updatemd' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-edit"></span>', $url, [
                    'title' => Yii::t('app', 'Update Master Detail'),
                    'data-toggle'=>'tooltip',// 'role'=>'modal-remote',
                ]);
            },
        ],
        'urlCreator' => function($action, $model, $key, $index) { 
			return Url::to(['/plan/'.$action, 'empresa' => $model->empresa,'plan' => $model->plan,]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Modificar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Borrar', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'¿Esta seguro?',
                          'data-confirm-message'=>'¿Esta seguro de borrar este item?'], 
    ],

];   
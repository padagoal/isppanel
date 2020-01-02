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
        'attribute'=>'contrato',
		   
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'tiposervicio',
		   
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fechasolicitud',
		  'width' => '80px',
'format' => ['date', 'php:d-m-Y'], 
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fecharealizacion',
		  'width' => '80px',
'format' => ['date', 'php:d-m-Y'], 
    ],
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'tecnico',
        'hAlign'=>'right', 'format'=>['decimal',0],
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'estado',

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'realizado',
		  'format' => 'html',
'width' => '30px',					
'value' => function ($model) {
            if ($model->realizado) {
                return Html::a ( '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ');
            } else {
                return Html::a ( ' <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> ');
            }
        }, 
    ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'callcenter',
		   
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'tecnico',
		  'hAlign'=>'right', 'format'=>['decimal',0], 
    ],*/

    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ubicacion',
		   
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'observaciones',
		   
    ],*/
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
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width' => '120px',
        'template' => ' {cambioestado} - '.$template,
		 'buttons' => [
            'updatemd' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-edit"></span>', $url, [
                    'title' => Yii::t('app', 'Update Master Detail'),
                    'data-toggle'=>'tooltip',// 'role'=>'modal-remote',
                ]);
            },
             'cambioestado'=> function ($url, $model) {
                 return Html::a('<span class="glyphicon glyphicon-user"></span>', $url, [
                     'title' => Yii::t('app', 'Cambiar Estado'),
                     'data-toggle'=>'tooltip',// 'role'=>'modal-remote',
                 ]);
             },
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            if ($action === 'cambioestado') {
                return Url::to(['/serviciocliente/cambioestado', 'empresa' => $model->empresa,
                    'contrato' => $model->contrato,'tiposervicio' => $model->tiposervicio,
                    'fechasolicitud' => $model->fechasolicitud,]);
            }else{
                return Url::to(['/serviciocliente/'.$action, 'empresa' => $model->empresa,'contrato' => $model->contrato,'tiposervicio' => $model->tiposervicio,'fechasolicitud' => $model->fechasolicitud,]);
            }

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
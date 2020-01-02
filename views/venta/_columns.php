<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ventaid',
		   
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'vendedor',
		  'hAlign'=>'right', 'format'=>['decimal',0], 
    ],
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'empresa',
		   
    ], */
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'clienteid',
		   
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'estado',
		   
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'promocion',
		   
    ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'plantv',
		   
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'descuentotv',
		   
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'equipostv',
		  'hAlign'=>'right', 'format'=>['decimal',2], 
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'packsadicionales',
		   
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'planinternet',
		   
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'descuentointernet',
		   
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fechaventa',
		  'width' => '80px',
'format' => ['date', 'php:d-m-Y'], 
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'montomensual',
		  'hAlign'=>'right', 'format'=>['decimal',2], 
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'montoinstalacion',
		  'hAlign'=>'right', 'format'=>['decimal',2], 
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'montodescuentos',
		  'hAlign'=>'right', 'format'=>['decimal',2], 
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'parametroscobro',
		   
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
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action, 'ventaid' => $model->ventaid,]);
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
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
		   
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'clienteid',
		   
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cedula',
        'width' => '80px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cliente',
		   
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'zona',
		   
    ],
     [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'celular',
         'width' => '120px',
		   
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'whatsapp',
        'width' => '120px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'vendedor',
        'value' => function ($model) {
            return  $model->nombreusuario($model->vendedor);
        },
    ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'localizacion',
		   
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'lat',
		   
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'lon',
		   
    ],*/
     [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fechainicio',
		  'width' => '80px',
'format' => ['date', 'php:d-m-Y'], 
    ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fechacontrato',
		  'width' => '80px',
'format' => ['date', 'php:d-m-Y'], 
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'diadecorte',
		  'hAlign'=>'right', 'format'=>['decimal',Yii::$app->params['decimals']], 
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'estado',
		   
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'callcenter',
		  'hAlign'=>'right', 'format'=>['decimal',0], 
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'vendedor',
		  'hAlign'=>'right', 'format'=>['decimal',0], 
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'monto',
		  'hAlign'=>'right', 'format'=>['decimal',Yii::$app->params['decimals']], 
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nir',
		   
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ccc',
		   
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'observaciones',
		   
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'pordefecto',
		  'format' => 'html',
'width' => '30px',					
'value' => function ($model) {
            if ($model->enabled) {
                return Html::a ( '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ');
            } else {
                return Html::a ( ' ');
            }
        }, 
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'interno',
		  'format' => 'html',
'width' => '30px',					
'value' => function ($model) {
            if ($model->enabled) {
                return Html::a ( '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ');
            } else {
                return Html::a ( ' ');
            }
        }, 
    ],*/
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'orden',
		  'hAlign'=>'right', 'format'=>['decimal',Yii::$app->params['decimals']], 
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
        'template' => ' {vender} - '.$template,
		 'buttons' => [
             'vender' => function ($url, $model) {
                 return Html::a('<span class="glyphicon glyphicon-usd"></span>', $url, [
                     'title' => Yii::t('app', 'Update Master Detail'),
                     'data-toggle'=>'tooltip', //'role'=>'modal-remote',
                 ]);
             },
            'updatemd' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-edit"></span>', $url, [
                    'title' => Yii::t('app', 'Update Master Detail'),
                    'data-toggle'=>'tooltip',// 'role'=>'modal-remote',
                ]);
            },
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            if ($action === 'vender') {
                return Url::to(['/contrato/venta', 'empresa' => $model->empresa,'clienteid' => $model->clienteid,]);
            } else return Url::to([$action, 'empresa' => $model->empresa,'clienteid' => $model->clienteid,]);
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
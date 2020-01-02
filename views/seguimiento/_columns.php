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
        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'seguimientoid',
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
        'attribute'=>'vendedor',
		  'hAlign'=>'right', 'format'=>['decimal',0], 
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fecha',
		  'width' => '80px',
'format' => ['date', 'php:d-m-Y'], 
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'seguimiento',
		   
    ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'comentario',
		   
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
			return Url::to([$action, 'seguimientoid' => $model->seguimientoid,]);
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
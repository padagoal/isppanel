<?php

use yii\widgets\DetailView;
use app\controllers\ContratoController;

/* @var $this yii\web\View */
/* @var $model app\models\Clientes */
?>
<div class="clientes-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'clienteid',
            'cliente',
            'contrato',
            'cedula',
            'direccion',
            'zona',
            'celular',
            'whatsapp',
            'localizacion',
            'lat',
            'lon',
            'fechainicio',
            'fechacontrato',
            'diadecorte',
            'estado',
            'callcenter',
            'vendedor',
            'monto',
            'nir',
            'ccc',
            'observaciones:ntext',
        ],
    ]) ?>

    <?  print ContratoController::generarEstadoCuenta($model->empresa,$model->contrato)?>

</div>

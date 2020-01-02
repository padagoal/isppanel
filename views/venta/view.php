<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Venta */
?>
<div class="venta-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ventaid',
            'vendedor',
            'empresa',
            'clienteid',
            'estado',
            'promocion',
            'plantv',
            'descuentotv',
            'equipostv',
            'packsadicionales',
            'planinternet',
            'descuentointernet',
            'fechaventa',
            'montomensual',
            'montoinstalacion',
            'montodescuentos',
            'parametroscobro',
            'observaciones:ntext',
            'created_by',
            'created_at',
            'modified_by',
            'modified_at',
        ],
    ]) ?>

</div>

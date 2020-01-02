<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Estadocuenta */
?>
<div class="estadocuenta-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'estadocuentaid',
            'contrato',
            'producto',
            'fechainicio',
            'periodo',
            'tipopago',
            'numerofactura',
            'vencimiento',
            'estadopago',
            'monto',
            'numerorecibo',
        ],
    ]) ?>

</div>

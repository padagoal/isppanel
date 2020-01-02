<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Factura */
?>
<div class="factura-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'numerofactura',
            'numfactura',
            'clienteid',
            'estadopago',
            'cliente',
            'fechaemision',
            'fechavto',
            'tipofactura',
        ],
    ]) ?>

</div>

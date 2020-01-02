<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Producto */
?>
<div class="producto-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'producto',
            'grupo',
            'descripcion',
            'precio',
            'maximo',
            'ciclico:boolean',
            'formaciclo',
            'cantidadciclo',
            'observaciones:ntext',
            'subgrupoproducto',
            'financiable:boolean',
            'puededescuento:boolean',
        ],
    ]) ?>

</div>

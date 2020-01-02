<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Promociondetalle */
?>
<div class="promociondetalle-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'producto',
            'plan',
            'promocion',
            'formadescuento',
            'cuotas',
            'descuento',
            'observaciones:ntext',
        ],
    ]) ?>

</div>

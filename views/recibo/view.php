<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Recibo */
?>
<div class="recibo-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'numerorecibo',
            'numero',
            'clienteid',
            'estadopago',
            'cobrador',
            'fechaemision',
        ],
    ]) ?>

</div>

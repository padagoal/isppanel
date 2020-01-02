<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Contratodetalle */
?>
<div class="contratodetalle-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'contrato',
            'producto',
            'fechainicio',
            'fechafin',
            'estado',
            'monto',
            'cantidad',
            'cuotas',
            'candowngrade:boolean',
            'adicionalalplan:boolean',
            'observaciones:ntext',
        ],
    ]) ?>

</div>

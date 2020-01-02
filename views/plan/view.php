<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Plan */
?>
<div class="plan-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'plan',
            'estado',
            'monto',
            'formaduracion',
            'duracion',
            'fechainicio',
            'fechafin',
            'observaciones:ntext',
            'modalidad',
        ],
    ]) ?>

</div>

<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Promocion */
?>
<div class="promocion-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'promocion',
            'estado',
            'fechadesde',
            'fechahasta',
            'observaciones',
        ],
    ]) ?>

</div>

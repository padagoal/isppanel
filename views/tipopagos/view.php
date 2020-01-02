<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tipopagos */
?>
<div class="tipopagos-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tipopago',
            'monto',
        ],
    ]) ?>

</div>

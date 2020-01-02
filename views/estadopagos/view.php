<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Estadopagos */
?>
<div class="estadopagos-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'estadopago',
        ],
    ]) ?>

</div>

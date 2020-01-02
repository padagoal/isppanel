<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Servicios */
?>
<div class="servicios-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'servicio',
            'monto',
            'maximomensual',
        ],
    ]) ?>

</div>

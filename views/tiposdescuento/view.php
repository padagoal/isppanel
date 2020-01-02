<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tiposdescuento */
?>
<div class="tiposdescuento-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tipo',
        ],
    ]) ?>

</div>

<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Financiacion */
?>
<div class="financiacion-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'financiacion',
            'observaciones:ntext',
            'estado',
        ],
    ]) ?>

</div>

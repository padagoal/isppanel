<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Financiaciondisponible */
?>
<div class="financiaciondisponible-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'plantv',
            'financiacion',
            'obligatorio:boolean',
            'observaciones:ntext',
        ],
    ]) ?>

</div>

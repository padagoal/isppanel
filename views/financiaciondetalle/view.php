<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Financiaciondetalle */
?>
<div class="financiaciondetalle-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'producto',
            'financiacion',
            'cuotas',
            'intereses',
            'observaciones:ntext',
        ],
    ]) ?>

</div>

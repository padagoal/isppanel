<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Plandetalle */
?>
<div class="plandetalle-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'plan',
            'producto',
            'cantidad',
            'maximo',
            'observaciones:ntext',
        ],
    ]) ?>

</div>

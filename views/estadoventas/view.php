<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Estadoventas */
?>
<div class="estadoventas-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'estado',
        ],
    ]) ?>

</div>

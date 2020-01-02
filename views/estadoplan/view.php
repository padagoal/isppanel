<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Estadoplan */
?>
<div class="estadoplan-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'estado',
        ],
    ]) ?>

</div>

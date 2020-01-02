<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Periodos */
?>
<div class="periodos-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'periodo',
            'fechainicio',
            'fechafin',
        ],
    ]) ?>

</div>

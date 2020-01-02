<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Estadopromos */
?>
<div class="estadopromos-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'estado',
        ],
    ]) ?>

</div>

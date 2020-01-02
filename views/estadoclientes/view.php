<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Estadoclientes */
?>
<div class="estadoclientes-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'estado',
        ],
    ]) ?>

</div>

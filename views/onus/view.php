<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Onus */
?>
<div class="onus-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'onuid',
            'oltid',
            'board',
            'port',
            'contrato',
        ],
    ]) ?>

</div>

<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Settopboxes */
?>
<div class="settopboxes-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'stbid',
            'estado',
            'contrato',
            'cardid',
            'fechainstalacion',
        ],
    ]) ?>

</div>

<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Grupoproductos */
?>
<div class="grupoproductos-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'grupo',
            'maximo',
            'servicio:boolean',
        ],
    ]) ?>

</div>

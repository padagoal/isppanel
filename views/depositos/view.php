<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Depositos */
?>
<div class="depositos-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cuenta',
            'numero',
            'monto',
            'fecha',
            'verificado:boolean',
        ],
    ]) ?>

</div>

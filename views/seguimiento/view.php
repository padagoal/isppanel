<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Seguimiento */
?>
<div class="seguimiento-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'seguimientoid',
            'clienteid',
            'vendedor',
            'fecha',
            'seguimiento',
            'comentario',
        ],
    ]) ?>

</div>

<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Servicioclientedetalle */
?>
<div class="servicioclientedetalle-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'producto',
            'contrato',
            'tiposervicio',
            'fechasolicitud',
        ],
    ]) ?>

</div>

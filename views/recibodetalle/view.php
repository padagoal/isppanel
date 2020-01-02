<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Recibodetalle */
?>
<div class="recibodetalle-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'numerorecibo',
            'estadocuentaid',
            'clienteid',
            'periodo',
            'tipopago',
            'monto',
        ],
    ]) ?>

</div>

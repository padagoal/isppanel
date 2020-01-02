<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Estadostb */
?>
<div class="estadostb-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'estado',
        ],
    ]) ?>

</div>

<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Olt */
?>
<div class="olt-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'oltid',
            'nombre',
        ],
    ]) ?>

</div>

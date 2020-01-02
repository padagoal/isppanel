<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Modalidades */
?>
<div class="modalidades-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'modalidad',
        ],
    ]) ?>

</div>

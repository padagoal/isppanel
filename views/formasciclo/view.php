<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Formasciclo */
?>
<div class="formasciclo-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'formaciclo',
        ],
    ]) ?>

</div>

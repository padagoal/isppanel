<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Formasduracion */
?>
<div class="formasduracion-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'formaduracion',
        ],
    ]) ?>

</div>

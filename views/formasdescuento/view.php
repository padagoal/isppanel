<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Formasdescuento */
?>
<div class="formasdescuento-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'formadescuento',
        ],
    ]) ?>

</div>

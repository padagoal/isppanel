<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tiposeguimiento */
?>
<div class="tiposeguimiento-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'seguimiento',
        ],
    ]) ?>

</div>

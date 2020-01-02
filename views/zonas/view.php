<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Zonas */
?>
<div class="zonas-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'zona',
        ],
    ]) ?>

</div>

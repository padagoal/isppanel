<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Promodisponible */
?>
<div class="promodisponible-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'plan',
            'promocion',
        ],
    ]) ?>

</div>

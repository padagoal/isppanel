<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Bancos */
?>
<div class="bancos-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cuenta',
            'banco',
        ],
    ]) ?>

</div>

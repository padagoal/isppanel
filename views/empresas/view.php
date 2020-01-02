<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Empresas */
?>
<div class="empresas-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'pais',
            'lenguaje',
        ],
    ]) ?>

</div>

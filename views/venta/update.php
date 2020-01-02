<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Venta */
?>
<div class="venta-update">

    <?= $this->render('_form', [
        'model' => $model,'cliente' => $cliente,
    ]) ?>

</div>

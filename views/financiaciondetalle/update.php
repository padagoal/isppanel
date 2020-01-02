<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Financiaciondetalle */
?>
<div class="financiaciondetalle-update">

    <?= $this->render('_form', [
        'model' => $model,
        'productosFinanciables' =>$productosFinanciables,
        'isUpdate'=>true

    ]) ?>

</div>

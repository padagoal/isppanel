<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Promociondetalle */
?>
<div class="promociondetalle-update">

    <?= $this->render('_form', [
        'model' => $model,
        'productosPromocionables' =>$productosPromocionables,
        'isUpdate'=>true
    ]) ?>

</div>

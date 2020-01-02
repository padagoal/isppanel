<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Financiaciondetalle */

?>
<div class="financiaciondetalle-create">
    <?= $this->render('_form', [
        'model' => $model,
        'plantv' =>$plantv,
        'productosFinanciables' =>$productosFinanciables,
        'isUpdate'=>false

    ]) ?>
</div>

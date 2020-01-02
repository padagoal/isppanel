<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Recibo */

?>
<div class="recibo-create">
    <?= $this->render('_form', [
        'model' => $model,
        'contrato'=>$contrato
    ]) ?>
</div>

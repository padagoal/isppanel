<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Factura */
?>
<div class="factura-update">

    <?= $this->render('_form_master_detail', [
        'model' => $model,
		'title' => $title,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
    ]) ?>

</div>

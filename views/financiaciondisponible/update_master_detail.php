<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Financiaciondisponible */
?>
<div class="financiaciondisponible-update">

    <?= $this->render('_form_master_detail', [
        'model' => $model,
		'title' => $title,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
    ]) ?>

</div>

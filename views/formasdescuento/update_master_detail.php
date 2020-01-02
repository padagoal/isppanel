<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Formasdescuento */
?>
<div class="formasdescuento-update">

    <?= $this->render('_form_master_detail', [
        'model' => $model,
		'title' => $title,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
    ]) ?>

</div>

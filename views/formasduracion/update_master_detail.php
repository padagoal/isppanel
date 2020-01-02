<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Formasduracion */
?>
<div class="formasduracion-update">

    <?= $this->render('_form_master_detail', [
        'model' => $model,
		'title' => $title,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
    ]) ?>

</div>

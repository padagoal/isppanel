<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Seguimiento */
?>
<div class="seguimiento-update">

    <?= $this->render('_form_master_detail', [
        'model' => $model,
		'title' => $title,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
    ]) ?>

</div>

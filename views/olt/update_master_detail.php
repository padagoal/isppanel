<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Olt */
?>
<div class="olt-update">

    <?= $this->render('_form_master_detail', [
        'model' => $model,
		'title' => $title,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
    ]) ?>

</div>

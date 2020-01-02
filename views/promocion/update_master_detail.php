<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Promocion */
?>
<div class="promocion-update">

    <?= $this->render('_form_master_detail', [
        'model' => $model,
		'title' => $title,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
        'dataProvider2' => $dataProvider2,
    ]) ?>

</div>

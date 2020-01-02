<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Serviciocliente */
?>
<div class="serviciocliente-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'contrato',
            'tiposervicio',
            'fechasolicitud',
            'fecharealizacion',
            'realizado:boolean',
            'callcenter',
            'tecnico',
            'estado',
            'ubicacion',
            'observaciones:ntext',
            'fechaasignacion',
            'fechareasignacion',
        ],
    ]) ?>

</div>

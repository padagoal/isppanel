<?php
/**
 * Created by PhpStorm.
 * User: padagoal
 * Date: 9/23/19
 * Time: 9:44 PM
 */

namespace app\models;

use Yii;


class Utiles
{

    public static function panel($titulo,$mensaje,$params,$existemensaje)
    {

        $cols = "";


        $mensajecol = '';

        if (!$existemensaje) {
            $aux = self::getRow($params);
            $cols .= $aux;
            $mensaje = '';
        } else {

            $mensajecol = '<tr data-key="estadopre" class="bg-success"> ';
            $mensajecol .= '<td data-col-seq="0" colspan="3"><center>'.$mensaje.'</center></td>';
            $mensajecol .= '</tr>';
        }


        $panel = <<< EOF
<div id="crud-datatable-preinstalacion" class="grid-view hide-resize" data-krajee-grid="kvGridInit_ebe0c92c">
<div class="panel panel-primary">
    <div class="panel-heading">    <div class="pull-right">
        <div class="summary"></div>
    </div>
    <h3 class="panel-title">
        <i class="glyphicon glyphicon-list"></i> $titulo
    </h3>
    <div class="clearfix"></div></div>
    <div class="kv-panel-before"> 
       <div class="btn-toolbar kv-grid-toolbar toolbar-container pull-right">    
    <div class="clearfix"></div></div>
   
    </div>
    <div id="crud-datatable-estadocuenta-container" class="table-responsive kv-grid-container">
        <table class="kv-grid-table table table-bordered table-condensed kv-table-wrap"><colgroup><col><col><col class="skip-export"></colgroup>
<thead>

<tr>
    <th data-col-seq="0" style="width: 30%;">Estado Pago</th>
    <th data-col-seq="1" style="width: 50%;">Monto</th>
    <th data-col-seq="1" style="width: 20%;">Accion</th>
</tr>

</thead>
<tbody> 
$mensaje
$cols

</tbody>
</table></div>
    <div class="kv-panel-after"></div>    
</div></div>
EOF;


    }



}
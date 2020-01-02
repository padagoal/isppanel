<?php
namespace app\models;
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 26/5/2017
 * Time: 08:50
 */
use Yii;

class Tools {
    /**
     * Convierte la fecha de modo dd-mm-yyyy en Y-m-d para postgres.
    */
    public static function pDate($fecha) {
        $aux = $fecha;
        if (strlen($fecha)>0) {
            $aux = $fecha;
            if(preg_match('/(..)-(..)-(....)/', $fecha, $match)) {
                $aux = $match[3] . '-' . $match[2] . '-' . $match[1];
            }
        }
        return $aux;
    }
    public static function dateFromdb($fecha) {
        $aux = $fecha;
        if (strlen($fecha)>0) {
            $aux = $fecha;
            if(preg_match('/(....)-(..)-(..)/', $fecha, $match)) {
                $aux = $match[3] . '-' . $match[2] . '-' . $match[1];
            }
        }
        return $aux;
    }
    public static function nombreUsuario($id) {
        if (empty($id)) return 'Sin Vendedor';
        $db = Yii::$app->db;
        $query = "select username from  \"user\" where id = :id and empresa = :empresa";
        $cmd=$db->createCommand($query)->bindValues(['id'=>$id,'empresa'=> Yii::$app->user->identity->empresa]);
        $rows = $cmd->queryOne();
        return $rows['username'];
    }

    public static function hasPreinstalacion($contrato,$empresa){
        //$existePreinstalacion = false;
        $db = Yii::$app->db;
        $query = <<<EOF
select estadopago,sum(monto) as monto
from estadocuenta
where contrato = :contrato and empresa = :empresa and (grupoproducto = 'Preinstalacion' or subgrupoproducto = 'Preinstalacion')
group by estadopago;
        
EOF;


        $cmd=$db->createCommand($query)->bindValues(['contrato'=>$contrato,'empresa'=>$empresa]);
        $aux = $cmd->queryOne();

        return $aux;
    }

    public static function cambioEstadoContratoCliente($empresa,$contrato,$estado,$clienteid){
        $db = Yii::$app->db;
        $query = <<< EOF
        SELECT actualizar_estado_cliente_contrato(:empresa, :contrato,:estado,:clienteid);
EOF;
        $db->createCommand($query)->bindValues(['empresa'=>$empresa,
            'clienteid'=>$clienteid,'estado'=>$estado,'contrato'=>$contrato])->execute();


    }

    public static function getEstadoContratoCliente($contrato,$clienteid,$empresa){

        $query =<<<EOF
select cl.estado as cliestado,c2.estado as conestado
from clientes cl
inner join contrato c2 on cl.empresa = c2.empresa and cl.clienteid = c2.clienteid
where cl.clienteid = :clienteid and c2.contrato = :contrato and c2.empresa =:empresa;
EOF;
        $db = Yii::$app->db;
        $row = $db->createCommand($query)->bindValues(['empresa'=>$empresa,
            'clienteid'=>$clienteid,'contrato'=>$contrato])->queryOne();

        return $row;


    }

    public static function agregarTiempoAFecha($fecha,$tiempo,$unidad){

        $t = strtotime($fecha);
        $t2 = strtotime('+'.$tiempo.' '.$unidad,$t);

        return date('Y-m-d',$t2);


    }

}


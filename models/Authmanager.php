<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 15/2/2018
 * Time: 11:03
 */
namespace app\models;

use Yii;
use yii\helpers\Html;
/**
 * This is the model class for table "categories".
 *
 * @property string $category
 *
 * @property Programs[] $programs
 */
class Authmanager extends \yii\db\ActiveRecord
{
    public function Auth($model, $role)
    {
        return true;
        $auth['monitor'] = ['programstrancoding','transcodingservers','actionpending'];
        if ($role = 'None') {
            return false;
        } elseif ($role === 'Admin') {
            return true;
        } else {
            return array_key_exists($role,$auth[$model]);
        }
        return false;
    }

    public function Verify($modelo,$accion, $userid){
        $db = Yii::$app->db;
        $query = "select profile from \"user\" where id= :id";
        $cmd=$db->createCommand($query)->bindValues(['id'=>$userid]);
        $auxprofile = $cmd->queryOne();
        $profile  = $auxprofile['profile'];
        $query = "select count(*) cantidad from autorizacion where modelo= :modelo and accion = :accion and profile= :profile";
        $cmd=$db->createCommand($query)->bindValues(['modelo'=>$modelo,'accion'=>$accion, 'profile' => $profile ]);
        $rows = $cmd->queryOne();

        //Yii::debug("AuthManager : [$modelo,$accion, $profile]" );
        //Yii::debug("AuthManager returns: " . $rows['cantidad']);
       // print_r("Rows ".$rows );
        return ($rows['cantidad']>0)?true:false;
    }
    public function IndexToolbar($modelo,$accion, $userid, $title, $modal, $create = true){
        $cancreate = self::Verify($modelo,$accion, $userid)  && $create;
        $content = "";
        if (strlen($modal)>0) {
            $content .= ($cancreate) ? Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['title' => Yii::t('app', 'Create new') . ' ' . Yii::t('app', $title), 'role'=>'modal-remote','class' => 'btn btn-success',]) : "";
        } else {
            $content .= ($cancreate) ? Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['title' => Yii::t('app', 'Create new') . ' ' . Yii::t('app', $title), 'class' => 'btn btn-success',]) : "";
        }
        $content .= Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>Yii::t('app', 'Reset')]);
        $content .= '{toggleData}';
        $content .= '{export}';
        return $content;
    }
    public function ColumnsToolbar($modelo, $userid){
        $content = '';
        $aux  = self::Verify($modelo,'view', $userid);
        Yii::trace('view' . $aux);
        $content .= ($aux===true)?' {view} ': ' ';
        $content .= (self::Verify($modelo,'update', $userid)===true)?' {update} ': ' ';
        $content .= (self::Verify($modelo,'updatemd', $userid)===true)?' {updatemd} ': ' ';
        $aux = self::Verify($modelo,'delete', $userid);
            Yii::trace('delete ' . $aux);
        $content .= ($aux===true)?' {delete} ': ' ';
        return $content;
    }
}
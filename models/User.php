<?php

namespace app\models;

use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{
    public function register()
    {
        parent::register(); // do your magic
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // add field to scenarios
        $scenarios['create'][]   = 'empresa';
        $scenarios['update'][]   = 'empresa';
        $scenarios['register'][] = 'empresa';

        $scenarios['create'][]   = 'profile';
        $scenarios['update'][]   = 'profile';
        $scenarios['register'][] = 'profile';

        $scenarios['create'][]   = 'nombre';
        $scenarios['update'][]   = 'nombre';
        $scenarios['register'][] = 'nombre';

        $scenarios['create'][]   = 'habilitado';
        $scenarios['update'][]   = 'habilitado';
        $scenarios['register'][] = 'habilitado';

        $scenarios['create'][]   = 'comision';
        $scenarios['update'][]   = 'comision';
        $scenarios['register'][] = 'comision';

        return $scenarios;
    }

    public function rules()
    {
        $rules = parent::rules();
        // add some rules
        //$rules['fieldRequired'] = ['product', 'required'];
        $rules['empresaRequired'] = ['empresa', 'required'];
        $rules['empresaLength']   = ['empresa', 'string', 'max' => 255];
        $rules['profileLength']   = ['profile', 'string', 'max' => 255];
        $rules['nombre']   = ['nombre', 'string', 'max' => 255];
        $rules['habilitado']   = ['habilitado', 'boolean'];
        $rules['comision']   = ['nombre', 'number'];
        return $rules;
    }
    public function getEmpresa()
    {
        return $this->getAttribute('empresa');
    }
    public function getProfile()
    {
        return $this->getAttribute('profile');
    }
}
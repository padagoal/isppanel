<?php

namespace app\controllers\user;

use dektrium\user\controllers\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
    public function actionUpdateproduct($product)
    {
        $cantidad = Projectusers::find()->andWhere(['id'=>Yii::$app->user->id])->andWhere(['product'=>$product])->count();
        if ($cantidad == 0) {
            return $this->redirect(['/user/login']);
        }
        $model =  User::find()->where(['id'=>Yii::$app->user->id])-one();
        $model['product'] = $product;
        $model->save();
    }
}
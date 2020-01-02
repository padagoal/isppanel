<?php

/**
 * @var yii\widgets\ActiveForm    $form
 * @var dektrium\user\models\User $user
 */
use yii\helpers\ArrayHelper;
use app\models\Userprofile;

$profile = ArrayHelper::map(Userprofile::find()->where(['not in','profile',['Admin','Super']])->all(), 'profile', 'profile');
$user->empresa = Yii::$app->user->identity->empresa;

?>

<!-- ?= $form->field($user, 'product')->dropDownList($items); ?-->
<?= $form->field($user, 'username')->textInput(['maxlength' => 25]) ?>
<?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'password')->passwordInput() ?>
<?= $form->field($user, 'profile')->dropDownList($profile) ?>


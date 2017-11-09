<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Login';
?>
<div style="display:flex" class="site-login">

    <div class="row" style="text-align: left; margin: 0 auto">
        <div class="col-lg-12">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username', ['options' =>
                [
                    'tag' => 'div',
                    'class' => 'form-group field-loginform-username has-feedback required '
                ],
                'template' => '{input}<span class="glyphicon glyphicon-user form-control-feedback"></span>{error}{hint}'])
                ->textInput(['autofocus' => true, 'placeholder' => 'Username']) ?>

            <?= $form->field($model, 'password', ['options' =>
                [
                    'tag' => 'div',
                    'class' => 'form-group field-loginform-password has-feedback required '
                ],
                'template' => '{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>{error}{hint}'])
                ->passwordInput(['placeholder' => 'Password']) ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div class="forgot_pass_p">
                If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
            </div>

            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

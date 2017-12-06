<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'position', [
        "template" => "<label> Position<span class='required_asterix'>*</span></label>\n{input}\n{hint}\n{error}"
    ])->dropDownList(['Worker' => 'Worker', 'Customer' => 'Customer'], ['prompt' => 'Select your position']) ?>

    <?= $form->field($model, 'full_name')->textInput()
        ->label('
                    <span class="full_name" style="display:none">Full </span><span class="company_name"  style="display:none">Company </span> 
                    Name<span class="required_asterix">*</span>') ?>

    <?= $form->field($model, 'username')->textInput()->label('Username <span class="required_asterix">*</span>') ?>

    <?= $form->field($model, 'password')->passwordInput()->label('Password <span class="required_asterix">*</span>') ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

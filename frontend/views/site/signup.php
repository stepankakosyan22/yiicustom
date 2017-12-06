<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \frontend\models\SignupForm */

use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

$this->title = 'Signup';
?>
<div style="display:flex;">
    <div class="col-lg-8" style="margin: -10px auto">

        <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin(
            [
                'options' => ['enctype' => 'multipart/form-data'],
                'id' => 'form-signup',
                'enableAjaxValidation' => true,
                'validationUrl' => Url::to('/index.php/site/validation')
            ]); ?>


        <?= $form->field($model, 'position', [
            "template" => "<label> Your position in We Do Apps <span class='required_asterix'>*</span></label>\n{input}\n{hint}\n{error}"
        ])->dropDownList(['Worker' => 'Worker', 'Customer' => 'Customer'], ['prompt' => 'Select your position']) ?>

        <?= $form->field($model, 'full_name')->textInput()
            ->label('
                    <span class="full_name" style="display:none">Full </span><span class="company_name"  style="display:none">Company </span> 
                    Name<span class="required_asterix">*</span>') ?>

        <?= $form->field($model, 'username')->textInput()->label('Username <span class="required_asterix">*</span>') ?>

        <?= $form->field($model, 'email')->textInput()->label('E-mail <span class="required_asterix">*</span>') ?>

        <?= $form->field($model, 'password')->passwordInput()->label('Password <span class="required_asterix">*</span>') ?>
        <div class="form-group">
            <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

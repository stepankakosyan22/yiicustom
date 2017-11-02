<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \frontend\models\SignupForm */

use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = 'Signup';
?>

    <div style="margin-left: 15% ">

        <div class="col-lg-8">
            <h1><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin(
                [
                    'id' => 'form-signup',
                    'enableAjaxValidation' => true,
                    'options' => ['enctype' => 'multipart/form-data'],
                    'validationUrl' => Url::to('/index.php/site/validation')
                ]); ?>

            <?= $form->field($model, 'position', [
                "template" => "<label> Your position in We Do Apps </label>\n{input}\n{hint}\n{error}"
            ])->dropDownList(['Worker' => 'Worker', 'Customer' => 'Customer']) ?>

            <div class="customer_inputs">
                <?= $form->field($model, 'company_name')->textInput() ?>
            </div>

            <div class="worker_inputs">

                    <div style="display:flex">
                        <div style='width:48%;margin-right:5px;float: left'>
                            <?= $form->field($model, 'first_name')->textInput()->label('Name') ?>
                        </div>
                        <div style='width:51%'>
                            <?= $form->field($model, 'last_name')->textInput()->label('Surname') ?>
                        </div>
                    </div>
                    <div style="display:flex">
                        <div style='width:48%;margin-right:5px;float: left'>
                            <?= $form->field($model, 'gender')
                                ->inline()
                                ->radioList(['Male' => 'Male', 'Female' => 'Female']); ?>
                        </div>
                        <div style='width:51%'>
                            <?= $form->field($model, 'prof_image')->fileInput(['class' => 'worker_inputs'])->label('Picture') ?>
                        </div>
                    </div>
                    <div style="display:flex">
                        <div style='width:48%;margin-right:5px;float: left'>
                            <?= $form->field($model, 'dob')->widget(
                                DatePicker::className(), ['inline' => false, 'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']
                            ])->label('Date of birth') ?>
                        </div>
                        <div style='width:51%'>
                            <?= $form->field($model, 'start_working_at')->widget(
                                DatePicker::className(), ['inline' => false, 'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']]
                            )->label('Start working at') ?>
                        </div>
                    </div>
                    <div style="display:flex">
                        <div style='width:48%;margin-right:5px;float: left'>
                            <?= $form->field($model, 'work_time')->dropDownList(['Full time' => 'Full time', 'Half time' => 'Half time'], ['prompt' => 'Select...']) ?>
                        </div>
                        <div style='width:51%'>

                            <?= $form->field($model, 'team')->dropDownList(['WEB' => 'WEB', 'Mobile' => 'Mobile'], ['prompt' => 'Select...']) ?>
                        </div>
                    </div>

            </div>

                <?= $form->field($model, 'username')->textInput() ?>

                <?= $form->field($model, 'email')->textInput() ?>

                <?= $form->field($model, 'password')->passwordInput() ?>
            </fieldset>
            <div class="form-group">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

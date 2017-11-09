<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\SignupForm */
/* @var $form ActiveForm */
$this->title = 'Edit ' . $model->position . ' page';
?>
<div style="display:flex;">
    <div class="col-lg-8" style="margin: -10px auto">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="form_imput_flex">
            <div class="form_imput_items">
                <?= $form->field($model, 'first_name')->textInput()->label('Name') ?>
            </div>
            <div style='width:51%'>
                <?= $form->field($model, 'last_name')->textInput()->label('Surname') ?>
            </div>
        </div>

        <div class="form_imput_flex">
            <div class="form_imput_items">
                <?= $form->field($model, 'gender')->radioList(['Male' => 'Male', 'Female' => 'Female']); ?>
            </div>
            <div style='width:51%'>
                <?= $form->field($model, 'prof_image')->fileInput()->label('Profile image') ?>
            </div>
        </div>

        <div class="form_imput_flex">
            <div class="form_imput_items">
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

        <div class="form_imput_flex">
            <div class="form_imput_items">
                <?= $form->field($model, 'work_time')->dropDownList(['Full time' => 'Full time', 'Half time' => 'Half time'], ['prompt' => 'Select...']) ?>
            </div>
            <div style='width:51%'>
                <?= $form->field($model, 'team')->dropDownList(['WEB' => 'WEB', 'Mobile' => 'Mobile'], ['prompt' => 'Select...']) ?>
            </div>
        </div>

        <?= $form->field($model, 'username') ?>

        <?= $form->field($model, 'email') ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success adding_new_project' : 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
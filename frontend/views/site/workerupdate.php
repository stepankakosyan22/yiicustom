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
    <div class="col-lg-10" style="margin: -10px auto">

        <h1><?= Html::encode($this->title) ?></h1>
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'id' => 'form-signup',
            'enableAjaxValidation' => false,
            'validationUrl' => Url::to('/site/uservalidation')
        ]); ?>

        <div style="width:40%;float:right;margin:10px;">
            <?php if (!empty($model->prof_image)){?>
                <img style="width:100%;float: left" class="img-rounded" src="/<?= $model->prof_image ?>"/>
            <?php } elseif($model->gender=="Male"){ ?>
                <img style="width:100%;float: left"  src="/uploads/User_male.png"/>
            <?php }else{?>
                <img style="width:100%;float: left"  src="/uploads/User_female.png"/>

            <?php }?>
        </div>

        <div style="width:49%;float:left;margin:10px;">
            <div class="form_imput_item">
                    <?= $form->field($model, 'full_name')->textInput()->label('Full Name') ?>

            </div>
            <div class="form_imput_flex">
                <div class="form_imput_items">
                    <?= $form->field($model, 'gender')->radioList(['Male' => 'Male', 'Female' => 'Female']); ?>
                </div>
                <div style='width:51%'>
                    <?= $form->field($model, 'prof_image')->fileInput(['value' => $model->prof_image])->label('Profile image') ?>
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
</div>
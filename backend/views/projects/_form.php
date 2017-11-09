<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use \yii\helpers\ArrayHelper;
use \yii\helpers\Url;
use \backend\models\Projects;
use \backend\models\User;
use \backend\models\ProjectWorker;
use kartik\select2\Select2;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $model backend\models\Projects */
/* @var $workers backend\models\ProjectWorker */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'New project';
?>
<div class="projects-form" style="display: flex;">

    <div class="col-lg-12" style="margin: 0 auto">
        <?php if (!$developers){ ?>
            <h1><?= Html::encode($this->title) ?></h1>
        <?php } ?>
        <?php $form = ActiveForm::begin(
            [
                'options' => ['enctype' => 'multipart/form-data'],
                'enableAjaxValidation' => true,
                'validationUrl' => Url::to('/projects/validation')]); ?>

        <?= $form->field($model, 'project_name')->textInput(['maxlength' => true])->label('Project name<span style="color:red;font-size: 125%">*</span>') ?>

        <?= $form->field($model, 'edf')->textInput() ?>

        <?= $form->field($model, 'start_date')->widget(
            DatePicker::className(), ['inline' => false, 'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd',]
        ])->label('Start date<span style="color:red;font-size: 125%">*</span>') ?>

        <?= $form->field($model, 'end_date')->widget(
            DatePicker::className(), ['inline' => false, 'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd',]
        ]) ?>

        <?= $form->field($model, 'customer')->dropDownList(ArrayHelper::map(User::find()
            ->where(['position' => 'Customer'])
            ->all(), 'id', "full_name"),['prompt'=>'Select customer'])->label('Choose customer<span style="color:red;font-size: 125%">*</span>') ?>

        <?= $form->field($model, 'logo')->fileInput(['style' => 'width:100%;border:1px solid #ccc;padding:5px;border-radius:4px']) ?>

        <button type="button"
                style="width: 100%;margin-bottom: 5px;background-color: forestgreen;color:whitesmoke"
                class="btn workers_added_button"
                data-toggle="collapse"
                data-target="#demo"
        >
            Select Workers
        </button>
        <br>
        <?php
        if($developers){
            $users=ArrayHelper::map(User::find()
                ->andWhere(['position' => 'Worker'])
                ->all(), 'id', "full_name");
            $workerList=[];
            foreach ($developers as $worker) {
                array_push($workerList,$worker['id_worker']);
                $workers->id_worker = $workerList;
            }
        }
        ?>


        <div id="demo" class="collapse">
            <?= $form->field($workers, 'id_worker')
                ->checkboxList(ArrayHelper::map(User::find()
                    ->andWhere(['position' => 'worker'])
                    ->groupBy('full_name')
                    ->all(), 'id', "full_name"), ['class' => 'workers'])->label('') ?>
        </div>
        <br>

        <div class="pull-right">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update',
                ['id'=>'button_id','class' => $model->isNewRecord
                    ? 'btn btn-success adding_new_project'
                    : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>

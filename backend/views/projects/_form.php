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

?>


<div class="projects-form">
    <div style="width:70%;float:left">
        <?php $form = ActiveForm::begin(
            [
                'options' => ['enctype' => 'multipart/form-data'],
                'enableAjaxValidation' => true,
                'validationUrl' => Url::to('/index.php/projects/validation')]); ?>

        <?= $form->field($model, 'project_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'edf')->textInput() ?>

        <?= $form->field($model, 'start_date')->widget(
            DatePicker::className(), ['inline' => false, 'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd',]
        ]) ?>

        <?= $form->field($model, 'end_date')->widget(
            DatePicker::className(), ['inline' => false, 'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd',]
        ]) ?>

        <?= $form->field($model, 'customer')->dropDownList(ArrayHelper::map(User::find()
            ->where(['position' => 'Customer'])
            ->all(), 'id', "company_name"),['prompt'=>'Select customer']) ?>

        <?= $form->field($model, 'logo')->fileInput(['style' => 'width:100%;border:1px solid #ccc;padding:5px;border-radius:4px']) ?>

    </div>
    <div style="width:28%;float:right;margin-top:24px;">

        <button type="button"
                style="width: 100%;margin-bottom: 5px;background-color: #0f0f0f;color:whitesmoke"
                class="btn workers_added_button"
                data-toggle="collapse"
                data-target="#demo"
        >
            Select Workers
        </button>
        <br>


        <div id="demo" class="collapse">
            <?= $form->field($workers, 'id_worker')
                ->checkboxList(ArrayHelper::map(User::find()
                    ->andWhere(['position' => 'worker'])
                    ->groupBy('first_name')
                    ->all(), 'id', "first_name"), ['class' => 'workers'])->label('') ?>
        </div>
        <br>
    </div>
    <!--    --><? //= $form->field($workers, 'id_worker')->dropDownList(
    //        ArrayHelper::map( User::find()->all(), 'id', 'username')) ?>
    <!--    -->

    <!--    --><? //=
    //    $form->field($workers, 'id_worker')->widget(
    //         Select2::classname(), [
    //        'data' =>  ArrayHelper::map(User::find()->all(), 'id', 'username'),
    //        'language' => 'en',
    //        'options' => ['placeholder' => 'Select workers ...'],
    //        'pluginOptions' => [
    //            'allowClear' => true
    //        ]])
    //    ?>


    <div class="pull-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success adding_new_project' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>

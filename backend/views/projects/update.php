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

$this->title = 'Edit Project: ' . $model->project_name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_project, 'url' => ['view', 'id' => $model->id_project]];
$this->params['breadcrumbs'][] = 'Update';
$workerss = (new Query())
    ->select('*')
    ->from('project_worker')
    ->join('INNER JOIN', 'user', 'project_worker.id_worker=user.id')
    ->where(['project_worker.id_project' => $model->id_project])
    ->all();
?>
<div class="projects-update">
    <div><img style="width:150px;height:100px; float:left" src="/<?= $model->logo ?> ">
    </div>
    <br><br>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(
        [
            'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>

    <?= $form->field($model, 'project_name')->textInput(['maxlength' => true, 'autofocus' => true]) ?>

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

    <?php foreach ($developers as $worker) {
        $workers->id_worker = $worker['id_worker'];
    } ?>

    <?= $form->field($workers, 'id_worker')->checkboxList(ArrayHelper::map(User::find()
            ->andWhere(['position' => 'Worker'])
            ->all(), 'id', "first_name"), ['class' => 'workers']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success adding_new_project' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

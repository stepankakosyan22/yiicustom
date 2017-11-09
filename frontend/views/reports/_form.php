<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use \app\models\Projects;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $model app\models\Reports */
/* @var $form yii\widgets\ActiveForm */

$current_user_id=\Yii::$app->user->id;
?>

<div class="reports-form">

    <?php $form = ActiveForm::begin([ 'enableClientValidation' => true,
        'options'                => [
            'id'      => 'dynamic-form'
        ]]); ?>

    <?= $form->field($model, 'id_project')->dropDownList(
            ArrayHelper::map((new Query())
                ->select('*')
                ->from('project_worker')
                ->where(['id_worker'=>$current_user_id])
                ->join('INNER JOIN','projects', 'project_worker.id_project = projects.id_project')
                ->all(), 'id_project', 'project_name'),
            ['prompt'=>'Select Project']
    )->label('Choose project <span class="required_asterix">*</span>')  ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Report text <span class="required_asterix">*</span>')  ?>

    <div style="display: none;">
        <?= $model->working_time='1' ?>
    </div>
    <?= $form->field($model, 'working_time')
        ->radioList(['1'=>'Full day','0.5'=>'Half day'])
        ->label('Working time <span class="required_asterix">*</span>')  ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

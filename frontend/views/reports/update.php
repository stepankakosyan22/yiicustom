<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use yii\db\Query;
/* @var $this yii\web\View */
/* @var $model frontend\models\Reports */
/* @var $form ActiveForm */
$this->title = 'Update today\'s report';
$current_user_id=\Yii::$app->user->id;


?>

<div class="reports-form">

    <?php $form = ActiveForm::begin([ 'enableClientValidation' => true,
        'options'                => [
            'id'      => 'dynamic-form'
        ]]); ?>

<?php if (substr($model->report_day,0,10)==date('Y-m-d')){ ?>

    <?= $form->field($model, 'id_project')->dropDownList(
        ArrayHelper::map((new Query())
            ->select('*')
            ->from('project_worker')
            ->where(['id_worker'=>$current_user_id])
            ->join('INNER JOIN','projects', 'project_worker.id_project = projects.id_project')
            ->all(), 'id_project', 'project_name'),['disabled' => true])
            ->label('Project')  ?>

    <?= $form->field($model, 'report_day')->textInput(['readonly' => true])?>

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
<?php }else{?>
    <h2 class="alert alert-danger">You cannot edit<strong><a href="/reports/index" class="alert-link"> old reports!<a></strong></h2>
<?php } ?>

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

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_project')->dropDownList(
            ArrayHelper::map((new Query())
                ->select('*')
                ->from('project_worker')
                ->where(['id_worker'=>$current_user_id])
                ->join('INNER JOIN','projects', 'project_worker.id_project = projects.id_project')
                ->all(), 'id_project', 'project_name'),
            ['prompt'=>'Select Project']
    ) ?>

<!--    --><?//= $form->field($model, 'id_user')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'working_time')->radioList(['1'=>'Full day','0.5'=>'Half day']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

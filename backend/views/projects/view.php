<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $model backend\models\Projects */
/* @var $workers_project backend\models\User */

$this->title = $model->id_project;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$workers_project=(new Query())
    ->select('*')
    ->from('user')
    ->join('INNER JOIN', 'project_worker','project_worker.id_worker=user.id')
    ->join('INNER JOIN', 'projects','project_worker.id_project=projects.id_project')
    ->where(['projects.id_project'=> $model->id_project])
    ->all();
?>
<div class="projects-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_project], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_project], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_project',
            'project_name',
            'edf',
            'start_date',
            'end_date',
            'customer',
            'logo',
        ],
    ]) ?>

    <?php if($workers_project){ foreach ($workers_project as $worker){ ?>
       <pre>Worker:<?= $worker['first_name'].' '.$worker['last_name'] ?></pre>
    <?php }}else{ ?>
        <pre>Edit project for adding workers!</pre>
    <?php } ?>
</div>

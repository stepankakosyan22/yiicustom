<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Projects */
/* @var $workers backend\models\ProjectWorker */

$this->title = 'Edit Project: ' . $model->id_project;

?>
<div class="projects-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'workers'=>$workers,
        'developers'=>$developers
    ]) ?>
</div>

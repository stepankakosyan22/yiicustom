<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Projects */
/* @var $workers backend\models\ProjectWorker */

$this->title = 'New project';
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'workers'=> $workers,
    ]) ?>
</div>


<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Projects */
/* @var $workers backend\models\ProjectWorker */

$this->title = 'New project';

?>
<div class="projects-create">
    <?= $this->render('_form', [
        'model' => $model,
        'workers'=> $workers,
    ]) ?>
</div>


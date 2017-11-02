<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Reports */

$this->title = 'Add Reports';
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reports-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

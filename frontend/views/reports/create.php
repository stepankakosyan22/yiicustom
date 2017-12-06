<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Reports */

$this->title = 'Add Reports';
?>
<div class="reports-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

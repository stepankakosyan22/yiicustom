<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
$this->title = 'Create User';
?>
<div class="user-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

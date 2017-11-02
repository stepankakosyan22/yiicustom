<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Workers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions'=>function($model){
            if($model->username == 'admin'){
                return ['style'=>'display:none'];
            }
        },
        'columns' => [
            'first_name',
            'last_name',
            'gender',
            'dob',
            'team',
            'work_time',
            'start_working_at'
        ],
    ]); ?>
</div>

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

<?php if (substr($model->report_day,0,10)==date('Y-m-d')){ ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


<?php }else{?>
    <h2 class="alert alert-danger">You cannot edit<strong><a href="/reports/index" class="alert-link"> old reports!<a></strong></h2>
<?php } ?>
</div>
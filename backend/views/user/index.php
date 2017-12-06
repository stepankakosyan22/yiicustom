<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
?>
<div class="user-index">


    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php if (isset($workers) && $workers != null) { ?>
        <h3>Workers</h3>
    <?php } ?>
    <table class="table table-hover">
        <?php if (isset($workers)) {
            foreach ($workers as $worker) { ?>
                <tr>
                    <td style="cursor: pointer"
                        onclick="window.location='/user/view/<?= $worker['id'] ?>'"><?= $worker['full_name'] ?></td>
                    <td>
                        <a style="line-height: 0.5" href="/user/update/<?= $worker['id'] ?>">
                            <span class="edit_delit_icon glyphicon glyphicon-edit pull-right" title="Edit"> </span>
                        </a>
                        <?= Html::a('  <span class="edit_delit_icon glyphicon glyphicon-trash pull-right" title="Delete"></span>',
                            ['/user/delete', 'id' => $worker['id']], [
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                    </td>
                </tr>
            <?php }
        } ?>
    </table>
    <?php if (isset($workers) && $workers != null) { ?>
        <h3>Customers</h3>
    <?php } ?>
    <table class="table table-hover">
        <?php if (isset($customers)) {
            foreach ($customers as $customer) { ?>
                <tr>
                    <td><?= $customer['full_name'] ?></td>
                    <td><a style="line-height: 0.5" href="/user/update/<?= $customer['id'] ?>">
                            <span class="edit_delit_icon glyphicon glyphicon-edit pull-right" title="Edit"> </span>
                        </a>
                        <?= Html::a('  <span class="edit_delit_icon glyphicon glyphicon-trash pull-right" title="Delete"></span>',
                            ['/user/delete', 'id' => $customer['id']], [
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                    </td>
                </tr>
            <?php }
        } ?>
    </table>

</div>

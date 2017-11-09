<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use frontend\controllers\ReportsController;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reports';
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="reports-index">

    <?php if ($reports) { ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <table class="report_table">
        <tr class="report_tr">
            <th class="report_th">Report day</th>
            <th class="report_th">Project name</th>
            <th class="report_th">Discription</th>
            <th class="report_th">Working day</th>
        </tr>
        <?php
        foreach ($reports as $report) { ?>
        <?php $rep_day=substr($report['report_day'],0,10);  if ($rep_day!=date('Y-m-d')){ ?>
            <tr class="report_tr">
                <td class="report_td"><?= $report['report_day'] ?></td>
                <td class="report_td"><?= $report['project_name'] ?></td>
                <td class="report_td"><?= $report['description'] ?></td>
                <?php if ($report['working_time'] == '1') { ?>
                    <td class="report_td">Full day</td>
                <?php } else { ?>
                    <td class="report_td">Half day</td>
                <?php } ?>
            </tr>
                <?php }else{ ?>
                <tr class="report_tr">
                    <td class="report_td"><?= $report['report_day'] ?></td>
                    <td class="report_td"><?= $report['project_name'] ?></td>
                    <td class="report_td"><?= $report['description'] ?></td>
                    <?php if ($report['working_time'] == '1') { ?>
                        <td class="report_td">Full day
                            <a href="/reports/update/<?= $report['id_report'] ?>">
                                <span style="float:right;font-size: 150%" class="glyphicon glyphicon-edit"></span>
                            </a>
                        </td>
                    <?php } else { ?>
                        <td class="report_td">Half day
                            <a  href="/reports/update/<?= $report['id_report'] ?>">
                                <span style="float:right;font-size: 150%" class="glyphicon glyphicon-edit"></span>
                            </a>
                        </td>
                    <?php } ?>
                </tr>
            <?php }?>
        <?php } ?>
        <div class="rep_add_btn">

            <?= Html::button('<span>Add Reports</span>',
                ['value' => Url::to('/reports/create'),
                    'class' => 'report_added_button',
                    'style' => 'vertical-align:middle',
                    'id' => 'reportModalButton']) ?>
        </div>
        <?php
        Modal::begin([
            'header' => '<h2>Today\'s report</h2>',
            'id' => 'modal',
            'size' => 'modal-lg',
        ]);
        echo '<div id="reportModalContent"></div>';
        Modal::end();
        ?>
    </table>
    <div style="display: flex">
        <div style="margin:0 auto">
        <?= LinkPager::widget([
            'pagination' => $pagination,
        ]) ?>
            <div>
    </div>
</div>

<?php } else { ?>

    <div style="width:100%;text-align: center">
        <?= Html::button('<span>Add your first report</span>',
            ['value' => Url::to('create'),
                'class' => 'report_added_button',
                'style' => 'vertical-align:middle;font-size:150%;width:35%',
                'id' => 'reportModalButton']) ?>
    </div>
    <?php
    Modal::begin([
        'header' => '<h2>Today\'s report</h2>',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);
    echo '<div id="reportModalContent"></div>';
    Modal::end();
    ?>
<?php } ?>
</div>


<!--    --><? //= GridView::widget([
//        'dataProvider' => $dataProvider,
//        'columns' => [
////            ['class' => 'yii\grid\SerialColumn'],
//
//            'report_day',
//            'projectsProject.project_name',
//            'description:ntext',
//             'working_time',
//
////            ['class' => 'yii\grid\ActionColumn'],
//        ],
//    ]); ?>
</div>

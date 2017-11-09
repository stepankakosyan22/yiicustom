<?php
/**
 * Created by PhpStorm.
 * User: WeDoApps
 * Date: 10/26/2017
 * Time: 11:27 AM
 */

use yii\helpers\Url;
use app\models\Projects;
use app\models\Reports;
use yii\helpers\Html;

$this->title = $project->project_name;

$reports = Reports::find()
    ->andWhere(['id_project' => $project->id_project])
    ->andWhere(['id_user' => Yii::$app->user->identity->id])
    ->all();
?>
<?php if ($project) { ?>
    <div class="user_proj_items">
        <div class="user_proj_items_logo">
            <?php if ($project->logo){ ?>
                <img style="width:100%"
                     src="<?php echo Yii::$app->urlManagerBackend->baseUrl; ?>/<?= $project->logo ?>">
            <?php } else { ?>
                <img style="width: 100%" src="<?php echo Yii::$app->urlManagerBackend->baseUrl; ?>/uploads/Project.png">
            <?php } ?>
        </div>
        <div style="width:65%;margin-left: 5%">
            <table  class="table table-sm table-inverse">
                <tr class="table_header_tr">
                    <td colspan="5"><?= $project->project_name ?></td>
                </tr>
                <?php if ($project->edf){?>
                <tr>
                    <td>Estimated days to finish of project:</td>
                    <td><?= $project->edf ?> day</td>
                </tr>
                <?php } ?>
                <tr>
                    <td>Project started at:</td>
                    <td><?= $project->start_date ?></td>
                </tr>
                <?php if ($project->end_date){?>
                    <tr>
                        <td>Project should end at:</td>
                        <td><?= $project->end_date ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>Customer of project:</td>
                    <?php foreach ($customer_name as $cus_name){
                        if ($cus_name['id']==$project->customer){?>
                            <td><?= $cus_name['full_name'] ?></td>
                        <?php }}?>
                </tr>
            </table>
        </div>
    </div>
<?php } ?>

<?php if ($reports) { ?>
    <table class="report_table">
        <tr class="report_tr">
            <th class="report_th">Report day</th>
            <th class="report_th">Working time</th>
            <th class="report_th">Description</th>
        </tr>
        <?php foreach ($reports as $report) { ?>

            <tr class="report_tr">
                <td class="report_td"><?= $report->report_day ?></td>
                <?php if ($report->working_time == '1') { ?>
                    <td class="report_td">Full day</td>
                <?php } else { ?>
                    <td class="report_td">Half day</td>  <?php } ?>
                <td class="report_td"><?= $report->description ?></td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>

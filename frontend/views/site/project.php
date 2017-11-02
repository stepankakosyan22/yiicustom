<?php
/**
 * Created by PhpStorm.
 * User: WeDoApps
 * Date: 10/26/2017
 * Time: 11:27 AM
 */

use frontend\controllers\UserController;
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
    <div class="project_item">

        <div style="font-size: 25px;text-align: center;width:100%"><?= $project->project_name ?></div>
            <img style="width:26%;float:left" src="<?php echo Yii::$app->urlManagerBackend->baseUrl; ?>/<?= $project->logo ?>">
            <div class="project_datas">Estimated days to finish of project: <?= $project->edf ?></div>
            <div class="project_datas">Project started at: <?= $project->start_date ?></div>
            <div class="project_datas">Project should end at:<?= $project->end_date ?></div>
            <div class="project_datas">Customer of project: <?= $project->customer ?></div>
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

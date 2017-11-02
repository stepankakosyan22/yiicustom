<?php
/**
 * Created by PhpStorm.
 * User: WeDoApps
 * Date: 10/26/2017
 * Time: 11:27 AM
 */

use yii\helpers\Url;
use backend\models\Projects;
use backend\controllers\SiteController;
use yii\db\Query;
use yii\helpers\Html;

$this->title = $project->project_name;

?>
<div>
    <div class="header_of_items">Project</div>
    <div class="project_datas_header"
         style="font-size: 25px;text-align: center"><?= $project->project_name ?>
        <a style="line-height: 0.5" href="/index.php/projects/update/<?= $project->id_project ?>">
           <span class="glyphicon glyphicon-edit"
                 style="float:right;color:black">
           </span>
        </a>
    </div>

    <div style="float:left;width:25%">
        <img src="/<?= $project->logo ?>" style="width:99%;height:150px;">
    </div>
    <div class="project_item" style="width:72%;float:right">
        <div class="project_datas">Estimated days to finish of project: <?= $project->edf ?></div>
        <div class="project_datas">Project started at: <?= $project->start_date ?></div>
        <div class="project_datas">Project should end at:<?= $project->end_date ?></div>
        <div class="project_datas">Customer of project: <?= $project->customer ?></div>
    </div>
    <br/><br/><br/><br/>
</div>

<div class="header_of_items">Workers</div>
<?php foreach ($workers_of_project as $worker) { ?>
    <div
            style="text-align: left; width: 100%;;height:73px;margin-bottom: 5px;background-color: black;color:whitesmoke;font-size: 150%"
            class="btn btn-default"
            data-toggle="collapse"
            data-target=".reports<?= $worker['id'] ?>"
    >
        <img style="width:60px;height:60px" class=" img-circle"
             src="<?php echo Yii::$app->urlManagerFrontend->baseUrl; ?>/<?= $worker['prof_image'] ?>">
        <?= $worker['first_name'] ?> <?= $worker['last_name'] ?>
    </div>

    <div class="reports<?= $worker['id'] ?> collapse">
        <?php if ($reports) { $infoExists[$worker['id']]=false; ?>
        <?php  foreach($reports as $rep){
                if($rep['id_user']==$worker['id']){
                    $infoExists[$worker['id']]=true;
                }
            }
            if($infoExists[$worker['id']]){
            ?>

            <div class="header_of_items">Daily reports</div>

            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th scope="col">Report day</th>
                    <th scope="col">Working time</th>
                    <th scope="col">Description</th>
                </tr>
                </thead>
                <?php foreach ($reports as $report) {
                    if ($report['id_user'] == $worker['id']) {
                        ?>
                        <tbody>
                        <tr>
                            <td><?= $report['report_day'] ?></td>
                            <?php if ($report['working_time'] == '1') { ?>
                                <td>Full day</td>
                            <?php } else { ?>
                                <td>Half day</td> <?php } ?>
                            <td><?= $report['description'] ?></td>
                        </tr>
                        </tbody>
                    <?php }
                } ?>
            </table>
        <?php }else{?>
                <div style="text-align: center"><?= $worker['first_name'] ?> hasn't put any report yet. </div>
            <?php }?>
            <br>
        <?php } else { ?>
            <div style="text-align: center"><?= $worker['first_name'] ?> hasn't put any report yet. </div><?php } ?>

    </div>

<?php } ?><br>


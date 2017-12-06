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

    <div class="project_items">
        <div style="float:left;width:25%">
            <?php if ($project->logo){?>
                <img src="/<?= $project->logo ?>" class="logo_project">
            <?php }else{ ?>
                <img src="/uploads/Project.png"  class="logo_project">
            <?php } ?>
        </div>

    <table style="width:75%"  class="table table-sm table-inverse">
        <tr style="border: none">
            <td colspan="2" style="font-size: 180%"><?= $project->project_name ?></td>
            <td style="font-size: 125%">
                <div class="proj_icons">
                    <a style="line-height: 0.5" href="/projects/update/<?= $project->id_project ?>">
                        <span class="edit_delit_icon glyphicon glyphicon-edit"  title="Edit"> </span>
                    </a>
                    <?= Html::a('  <span class="edit_delit_icon glyphicon glyphicon-trash" title="Delete"></span>',
                        ['/projects/delete', 'id' => $project->id_project], [
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </td>
        </tr>
        <?php if ( $project->edf){?>
            <tr>
               <td>Estimated days to finish of project: </td>
                <td><?= $project->edf ?> day</td>
            </tr>
        <?php }?>
        <?php if ($project->start_date){?>
            <tr>
                <td>Project started at: </td>
                <td><?= $project->start_date ?></td>
            </tr>
        <?php }?>
        <?php if ($project->end_date){?>
            <tr>
                <td>Project should end at:</td>
                <td><?= $project->end_date ?></td>
            </tr>
        <?php }?>

        <tr>
            <td>Customer of project: </td>
            <?php foreach ($customer_name as $cus_name){
                if ($cus_name['id']==$project->customer){?>
                    <td><?= $cus_name['full_name'] ?></td>
            <?php }}?>
        </tr>

    </table>
</div>

</div>
<?php if ($workers_of_project){ ?>
<div class="header_of_items">Workers</div>

<?php foreach ($workers_of_project as $worker) { ?>

    <div
            class="btn btn-default proj_item_colollapse"
            data-toggle="collapse"
            data-target=".reports<?= $worker['id'] ?>"
    >
        <?php if ( $worker['prof_image']){ ?>
        <img class="img-circle user_img_circle"
             src="<?php echo Yii::$app->urlManagerFrontend->baseUrl; ?>/<?= $worker['prof_image'] ?>">
        <?php }elseif($worker['gender']=="Female"){ ?>
            <img class="img-circle user_img_circle"
                 src="<?php echo Yii::$app->urlManagerFrontend->baseUrl; ?>/uploads/User_female.png ?>">
        <?php }else{ ?>
            <img class="img-circle user_img_circle"
                 src="<?php echo Yii::$app->urlManagerFrontend->baseUrl; ?>/uploads/User_male.png ?>">
        <?php } ?>
        <?= $worker['full_name'] ?>
    </div>

    <div class="reports<?= $worker['id'] ?> collapse">
        <?php if (!$reports){ ?>
            <div><?=$worker['full_name'] ?> hasn't put any report yet.</div>
        <?php }else {
            $infoExists[$worker['id']] = false; ?>
            <?php foreach ($reports as $rep) {
                if ($rep['id_user'] == $worker['id']) {
                    $infoExists[$worker['id']] = true;
                }
            }
            if ($infoExists[$worker['id']]) {
                ?>
                <div class="header_of_items">Daily reports</div>

                <table class="table table-bordered report_table">
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
            <?php } else {
                ?>
                <div style="text-align: center"><?= $worker['full_name'] ?> hasn't put any report yet.</div>
            <?php } ?>
            <br>
        <?php } ?>
    </div>
<?php } ?><br>

<?php } else{?>
    <div>There is no workers assigned to this project yet. <a href="/projects/update/<?= $project->id_project ?>">Edit</a> project for adding workers! </div>
<?php }?>

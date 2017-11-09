<?php

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

$this->title = Yii::$app->user->identity->full_name ;
?>
<?php if (!Yii::$app->user->isGuest) { ?>
    <!== CustomerSide !>
    <?php if (Yii::$app->user->identity->position == 'Customer') { ?>
        <?php $this->title = Yii::$app->user->identity->full_name ?>
        <h1>My projects</h1>
        <?php foreach ($customer_projects as $cust_proj) { ?>

            <div
                    class="btn btn-primary customer_coollapse_div"
                    data-toggle="collapse"
                    data-target=".project<?= $cust_proj['id_project'] ?>"
            >

            <?php if ($cust_proj['logo']){ ?>
             <img class="customer_coollapse_img"
             src="<?php echo Yii::$app->urlManagerBackend->baseUrl; ?>/<?= $cust_proj['logo'] ?>">
             <?php }else{ ?>
               <img class="customer_coollapse_img"
             src="<?php echo Yii::$app->urlManagerBackend->baseUrl; ?>/uploads/Project.png ?>">
             <?php } ?>

                 <?= $cust_proj['project_name'] ?>
            </div>

            <div class="project<?= $cust_proj['id_project'] ?> collapse">
                <p class="works_of_proj">Workers of this project</p>

                <?php foreach ($customer_projects_worker as $cust_proj_work) {
                    if ($cust_proj_work['id_project'] == $cust_proj['id_project']) { ?>

                        <div
                                style="width:100%;margin:3px"
                                class="btn btn-info"
                                data-toggle="collapse"
                                data-target=".workers<?= $cust_proj_work['id_worker'] ?><?= $cust_proj_work['id_project'] ?> "
                        >

                         <div style="font-size: 120%">
                         <?php if ($cust_proj_work['prof_image']){ ?>
                           <img class="customer_coollapse_img img-circle" src="/<?= $cust_proj_work['prof_image'] ?>">
                                <?php }elseif(!$cust_proj_work['prof_image'] && $cust_proj_work['gender']=='Female') {?>
                                   <img class="customer_coollapse_img" src="/uploads/User_female.png?>">
                                <?php }else{ ?>
                                       <img class="customer_coollapse_img" src="/uploads/User_male.png?>">
                                <?php } ?>
                          <?= $cust_proj_work['full_name'] ?>
                          </div>

                        </div>

                    <div class="workers<?= $cust_proj_work['id_worker'] ?><?= $cust_proj_work['id_project'] ?> collapse">

                        <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Report day</th>
                                <th scope="col">Working time</th>
                                <th scope="col">Description</th>
                            </tr>
                        </thead>
                        <?php foreach ($customer_projects_worker_report as $cust_proj_rep) {
                            if ($cust_proj_rep['id_project'] == $cust_proj['id_project'] &&
                                 $cust_proj_rep['id_user'] == $cust_proj_work['id_worker']) { ?>
                                <tbody>
                                <tr>
                                    <td><?= $cust_proj_rep['report_day'] ?></td>
                                    <?php if ($cust_proj_rep['working_time'] == '1') { ?>
                                        <td>Full day</td>
                                    <?php } else { ?>
                                        <td>Half day</td> <?php } ?>
                                    <td><?= $cust_proj_rep['description'] ?></td>
                                </tr>
                                </tbody>
                                </div>
                            <?php }
                        } ?>
                        </table>
                        </div>

                    <?php }
                } ?>
            </div>

        <?php } ?>

    <?php } ?>
    <!== end Customer side !>


    <!== start Worker side !>
    <?php if (Yii::$app->user->identity->position == 'Worker') { ?>
        <div class="user-index profile">
        <div class="user_datas">
        <a style="line-height: 0.5" href="/site/update/<?= Yii::$app->user->identity->id ?>">
           <span class="glyphicon glyphicon-edit worker_edit_button"></span>
        </a>
                <?php foreach ($user_datas as $userdata) { ?>
                    <?php if ($userdata['prof_image']) { ?>
                        <img src="/<?= $userdata['prof_image'] ?>" class="prof_image img-circle img-responsive">
                    <?php } elseif ($userdata['gender'] == "Male") { ?>
                        <img src="/uploads/User_male.png" class="prof_image img-responsive">
                    <?php } else { ?>
                        <img src="/uploads/User_female.png" class="prof_image img-responsive">
                    <?php } ?>
                    <div class="user_data_items" style="margin-left: 15px;">
                    <table style="width:65%"  class="table table-sm table-inverse">
                        <tr class="table_fullname">
                            <td colspan="2"><?= $userdata['full_name'] ?></td>
                        </tr>
                        <?php if ($userdata['dob']) {?>
                            <tr>
                                <td>Date of birth:</td>
                                <td><?= $userdata['dob'] ?></td>
                            </tr>
                        <?php }?>
                       <?php if ($userdata['gender']) {?>
                            <tr>
                                <td>Gender: </td>
                                <td><?= $userdata['gender'] ?></td>
                            </tr>
                        <?php } ?>
                        <?php if ($userdata['team']){?>
                            <tr>
                                <td>Team:</td>
                                <td><?= $userdata['team'] ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td>Work time:</td>
                            <td><?= $userdata['work_time'] ?></td>
                        </tr>
                        <tr>
                            <td>Email: </td>
                            <td><?= $userdata['email'] ?></td>
                        </tr>
                    </table>
                    </div>
                <?php } ?>
            </div>
            <br>
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

                <div class="project_title" >
                    Projects
                </div>

                <br/>
                <?php foreach ($user_projects as $user_project) { ?>
                    <a href="<?= Url::to(['/site/project', 'id_project' => $user_project['id_project']]) ?>">
                        <div class="user_project_datas"><?= $user_project['project_name'] ?></div>
                    </a>
                <?php } ?>
        </div>


    <?php } ?>


<?php } else { ?>

    <!==  GuestSide !>
    <?php $this->title = "WeDoApps"; ?>
    <div  class="default_page" style="text-align: center">
        <a href="<?= Url::to('/site/signup') ?>" class="btn btn-primary btn-lg login_button">
        <span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;&nbsp; Signup</a>
        <a href="<?= Url::to('/site/login') ?>" class="btn btn-primary btn-lg login_button">
        <span class="glyphicon glyphicon-log-in"></span>&nbsp;&nbsp;&nbsp;  Login</a>
        <img style="width:100%" src="/uploads/Open-plan-working.png" />
    </div>

<?php } ?>

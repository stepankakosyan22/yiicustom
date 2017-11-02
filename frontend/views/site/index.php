<?php

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$this->title = Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name;
?>
<?php if (!Yii::$app->user->isGuest) { ?>

    <!== CustomerSide !>
    <?php if (Yii::$app->user->identity->position == 'Customer') { ?>
        <?php $this->title = Yii::$app->user->identity->company_name ?>
        <h1>My projects</h1>
        <?php foreach ($customer_projects as $cust_proj) { ?>

            <div
                    style="text-align: left; width: 100%;;height:73px;margin-bottom: 5px;background-color: black;color:whitesmoke;font-size: 150%"
                    class="btn btn-default"
                    data-toggle="collapse"
                    data-target=".project<?= $cust_proj['id_project'] ?>"
            >
             <img style="width:60px;height:60px;background-color: white" class=" img-circle"
             src="<?php echo Yii::$app->urlManagerBackend->baseUrl; ?>/<?= $cust_proj['logo'] ?>">
                 <?= $cust_proj['project_name'] ?>
            </div>

            <div class="project<?= $cust_proj['id_project'] ?> collapse">
                <p>Workers of this project</p>

                <?php foreach ($customer_projects_worker as $cust_proj_work) {
                    if ($cust_proj_work['id_project'] == $cust_proj['id_project']) { ?>

                        <div
                                style="width:100%"
                                class="btn btn-default"
                                data-toggle="collapse"
                                data-target=".workers<?= $cust_proj_work['id_worker'] ?><?= $cust_proj_work['id_project'] ?> "
                        >

                         <div style="font-size: 120%">
                           <img style="width:60px;height:60px;background-color: white" class=" img-circle"
                                src="/<?= $cust_proj_work['prof_image'] ?>">
                          <?= $cust_proj_work['first_name'].' '. $cust_proj_work['last_name'] ?>
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

    <!== WorkerSide !>
    <?php if (Yii::$app->user->identity->position == 'Worker') { ?>
        <div class="user-index profile">
            <div class="user_datas">
                <?php foreach ($user_datas as $userdata) { ?>
                    <?php if ($userdata['prof_image']) { ?>
                        <img src="/<?= $userdata['prof_image'] ?>" class="prof_image img-circle img-responsive">
                    <?php } elseif ($userdata['gender'] == "Male") { ?>
                        <img src="/uploads/User_male.png" class="prof_image img-responsive">
                    <?php } else { ?>
                        <img src="/uploads/User_female.png" class="prof_image img-responsive">
                    <?php } ?>
                    <div class="user_data_items" style="margin-left: 15px;">
                        <div>Name:<?= $userdata['first_name'] ?> <?= $userdata['last_name'] ?></div>
                        <div>Date of birth: <?= $userdata['dob'] ?></div>
                        <div>Gender: <?= $userdata['gender'] ?></div>
                        <div>Team: <?= $userdata['team'] ?></div>
                        <div>Work time: <?= $userdata['work_time'] ?></div>
                        <div>Email: <?= $userdata['email'] ?></div>
                    </div>
                <?php } ?>
            </div>
            <br>
            <div style="display:inline-block;padding-bottom: 15px;">

                <?= Html::button('<span>Add Reports</span>', ['value' => Url::to('index.php/reports/create'),
                    'class' => 'report_added_button', 'style' => 'vertical-align:middle', 'id' => 'reportModalButton']) ?>
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
            <div class="user_projects">
                <div style="width:100%;font-size: 180%;margin:4px;text-align: center;background-color: #0f0f0f;color:whitesmoke;cursor: default">
                    Projects
                </div>
                <br/>
                <?php foreach ($user_projects as $user_project) { ?>
                    <a href="<?= Url::to(['/site/project', 'id_project' => $user_project['id_project']]) ?>">
                        <div class="user_project_datas"><?= $user_project['project_name'] ?></div>
                    </a>
                <?php } ?>
            </div>
        </div>


    <?php } ?>


<?php } else { ?>

    <!==  GuestSide !>
    <?php $this->title = "WeDoApps";
    ?>
    <div style="text-align: center">
        <h1>Welcome to WeDoApps</h1>

        <?php
        Modal::begin([
            'header' => '<h2>Login</h2>',
            'id' => 'login_modal',
            'size' => 'modal-sm',
        ]);
        echo '<div id="loginModalContent"></div>';
        Modal::end();
        ?>
        <div>
            <?= Html::button('Login', ['value' => Url::to('index.php/site/login'),
                'class' => 'btn login_button badge',
                'id' => 'loginModalButton']) ?>
            <span style="font-size: 140%;text-align: center">or</span>
            <a class="signup_button badge" href="index.php/site/signup">Signup</a>
        </div>
    </div>

<?php } ?>

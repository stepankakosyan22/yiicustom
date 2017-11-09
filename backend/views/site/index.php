<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */

$this->title = 'Admin side';

?>


<div>
    <?php foreach ($all_projects as $project) { ?>
        <a class="projs" href="<?= Url::to(['project', 'id_project' => $project->id_project]) ?>">
            <div class="all_projects panel ">
                <table class="table table-sm table-inverse">
                    <tr style=" padding-bottom: 3px">
                        <?php if ($project->logo) { ?>
                           <td><img src="/<?= $project->logo ?>" class="logo_project" style="height:150px"></td>
                        <?php } else { ?>
                            <td> <img src="/uploads/Project.png" class="logo_project"  style="height:150px"></td>
                        <?php } ?>
                    </tr>
                    <tr style="text-align: center;font-size: 150%">
                        <td>  <?= $project->project_name ?></td>
                    </tr>
                </table>
            </div>
        </a>
    <?php } ?>
    <div style="display: flex">
        <?= LinkPager::widget([
            'pagination' => $pagination,
        ]) ?>
    </div>
</div>

<a href="/projects/create" class="adding_project_button_a">
    <div class="btn adding_project_button">
        Add new project
    </div>
</a>
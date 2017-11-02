<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Admin side';

?>


<div>
    <?php foreach ($all_projects as $project) { ?>
        <a class="projs" href="<?= Url::to(['project', 'id_project' => $project->id_project]) ?>">
            <div class="all_projects panel ">
                <div style=" padding-bottom: 3px">
                    <?php if ($project->logo){ ?>
                    <img src="/<?= $project->logo ?>" style="width:99%;height:150px;">
                    <?php }else{ ?>
                        <img src="/uploads/Project.png"  style="width:99%;height:150px;">
                    <?php } ?>
                </div>
                <pre style="text-align: center;font-size: 150%"><?= $project->project_name ?></pre>
            </div>
        </a>
    <?php } ?>
</div>

<a href="index.php/projects/create" class="adding_project_button_a">
    <div class="btn adding_project_button">
        Add new project
    </div>
</a>
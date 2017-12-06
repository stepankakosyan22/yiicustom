<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Check in';
//echo '<pre>';
//print_r($checkins);die;
?>
<div class="checkin-index">
    <div <?php if (isset($chackedin) && $chackedin){ ?>disabled
         class="btn btn-success"<?php } else { ?> class="btn btn-success check_in" <?php } ?>>Check in
    </div>

    <?php if (isset($checkins) && $checkins) { ?>
        <table class="table-hover table">
            <tr>
                <th>Day</th>
                <th>Check in</th>
                <th>Lunch check out</th>
                <th>Lunch check in</th>
                <th>Check out</th>
                <th>Comment</th>
            </tr>
            <?php foreach ($checkins as $checkin) { ?>
                <tr data-id="<?= $checkin['checkin_id'] ?>">
                    <td><?= $checkin['day'] ?></td>
                    <td><?= $checkin['check_in'] ?></td>
                    <td>
                        <?php if ($checkin['lunch_check_out']) { ?>
                            <?= $checkin['lunch_check_out'] ?>
                        <?php } else { ?>
                            <div <?php if ($checkin['check_out']){ ?>disabled
                                 class="btn btn-success"<?php } else { ?> class="btn btn-success lunch_check_out" <?php } ?>
                                 style="display: flex">Lunch check out
                            </div>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if ($checkin['lunch_check_in']) {
                            echo $checkin['lunch_check_in'];
                        } else { ?>
                            <div
                                <?php if (!$checkin['lunch_check_out']) { ?>
                                    disabled class="btn btn-success"
                                <?php } else { ?>class="btn btn-success lunch_check_in"<?php } ?>
                                    style="display: flex"> Lunch check in
                            </div>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if ($checkin['check_out']) { ?>
                            <?= $checkin['check_out'] ?>
                        <?php } else { ?>
                            <div class="btn btn-success check_out"
                                <?php if (!$checkin['lunch_check_in'] && $checkin['lunch_check_out']) { ?>
                                    disabled<?php } ?>>Check out
                            </div>
                        <?php } ?>
                    </td>
                    <td style="max-width:300px">
                        <?php if ($checkin['comment']) { ?>
                            <?= $checkin['comment'] ?>
                        <?php } else { ?>
                            <div><input type="text"
                                        class="form-control pull-left comment_input<?= $checkin['checkin_id'] ?>"
                                        style="width:85%">
                                <div class="btn btn-info pull-right send_comment"><span
                                            class="glyphicon glyphicon-ok"></span></div>
                            </div>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>


</div>

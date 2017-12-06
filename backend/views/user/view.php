<?php
if (isset($model)){
    $this->title = $model->full_name;
}
?>
<?php if (isset($model)){?>
    <h1><?= $model->full_name ?></h1>
    <?php if(isset($checkins) && $checkins!=null){  ?>

    <h4>Month</h4>
    <table class="table-bordered table">
        <tr>
            <th>Year</th>
            <th>Month</th>
            <th>Worked hours</th>
            <th>Extra worked hours</th>
        </tr>
        <?php if (isset($months)){foreach ($months as $month){?>
            <tr>
                <td><?php $year=substr($month['day'],6,4); echo $year; ?></td>
                <td><?=$month['month'];  ?></td>
                <td><?php $m_h=$month['week_hours']/60; echo floor($m_h).' hour '; $m_m=$month['week_hours']%60; echo $m_m.' minute';  ?></td>
                <td><?php $m_h_e=$month['week_hours_extra']/60; echo floor($m_h_e).' hour '; $m_m_e=$month['week_hours_extra']%60; echo $m_m_e.' minute';  ?></td>
            </tr>
        <?php }}?>
    </table>

    <h4>Week</h4>
    <table class="table-bordered table">
        <tr>
            <th>Month</th>
            <th>Week number</th>
            <th>Worked hours</th>
            <th>Extra worked hours</th>
        </tr>
        <?php if (isset($hours)){foreach ($hours as $hour){?>
            <tr>
                <td><?=$hour['month'];  ?></td>
                <td><?= $hour['week'] ?></td>
                <td><?php $w_h=$hour['week_hours']/60; echo floor($w_h).' hour '; $w_m=$hour['week_hours']%60; echo $w_m.' minute';  ?></td>
                <td><?php $w_h_e=$hour['week_hours_extra']/60; echo floor($w_h_e).' hour '; $w_m_e=$hour['week_hours_extra']%60; echo $w_m_e.' minute';  ?></td>
            </tr>
        <?php }}?>
    </table>

    <h4>Day</h4>
    <table class="table table-bordered">
        <tr>
            <th>Day</th>
            <th>Check in</th>
            <th>Lunch check out</th>
            <th>Lunch check in</th>
            <th>Check out</th>
            <th>Comment</th>
        </tr>
        <?php if (isset($checkins)){foreach ($checkins as $checkin){?>
            <tr>
                <td><?= $checkin['day'] ?></td>
                <td><?= $checkin['check_in'] ?></td>
                <td><?= $checkin['lunch_check_out'] ?></td>
                <td><?= $checkin['lunch_check_in'] ?></td>
                <td><?= $checkin['check_out'] ?></td>
                <td style="max-width: 300px"><?= $checkin['comment'] ?></td>
            </tr>
        <?php }}?>
    </table>
<?php }}?>
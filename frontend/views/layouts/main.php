<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap\Modal;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Report Board',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    if (Yii::$app->user->isGuest) {
        $menuItems[]= '<li>'
            . Html::beginForm(['/'], 'post')
            .Html::submitButton(
                ' Home',
                ['class' => 'btn-link logout glyphicon glyphicon-home']
            )
            . Html::endForm()
            . '</li>';
        $menuItems[]= '<li>'
            . Html::beginForm(['/site/login'], 'post')
            .Html::submitButton(
                ' Login',
                ['class' => 'btn-link logout glyphicon glyphicon-log-in']
            )
            . Html::endForm()
            . '</li>';
    } elseif(Yii::$app->user->identity->position=='Worker') {
        $menuItems[]= '<li>'
            . Html::beginForm(['/site/index'], 'post')
            .Html::submitButton(
                ' Home',
                ['class' => 'btn-link logout glyphicon glyphicon-home']
            )
            . Html::endForm()
            . '</li>';
        $menuItems[]= '<li>'
            . Html::beginForm(['/reports/index'], 'post')
            .Html::submitButton(
                ' Reports',
                ['class' => 'btn-link logout glyphicon glyphicon-comment']
            )
            . Html::endForm()
            . '</li>';
        $menuItems[]= '<li>'
            . Html::beginForm(['/checkin/index'], 'post')
            .Html::submitButton(
                ' Checkin',
                ['class' => 'btn-link logout glyphicon glyphicon-time']
            )
            . Html::endForm()
            . '</li>';

        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                ' Logout',
                ['class' => 'btn-link logout glyphicon glyphicon-log-out']
            )
            . Html::endForm()
            . '</li>';
    } else{
        $menuItems[]= '<li>'
            . Html::beginForm(['/site/index'], 'post')
            .Html::submitButton(
                ' Home',
                ['class' => 'btn-link logout glyphicon glyphicon-home']
            )
            . Html::endForm()
            . '</li>';
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                ' Logout',
                ['class' => 'btn-link logout glyphicon glyphicon-log-out']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">

        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

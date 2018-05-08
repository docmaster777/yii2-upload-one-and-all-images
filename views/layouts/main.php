<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header>
    <div class="content">
        <hgroup>
            <h1>azbuka-klimata</h1>
            <i>Правильный климат</i>
        </hgroup>
    </div>
    <div class="overlay"></div>
</header>
<section class="site">
    <?php
    NavBar::begin([
        'brandLabel' => 'Азбука климата',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Главная', 'url' => ['/site/index']],
            ['label' => 'Перейти в магазин', 'url' => ['/shop/index']],
            ['label' => 'Полезная информация', 'url' => ['']],
            ['label' => 'Контакты', 'url' => ['/site/contact']],
//            Yii::$app->user->isGuest ? (
//            ['label' => 'Личный кабинет', 'url' => ['/site/login']]
//            ) : (
//                '<li>'
//                . Html::beginForm(['/site/logout'], 'post')
//                . Html::submitButton(
//                    'Logout (' . Yii::$app->user->identity->username . ')',
//                    ['class' => 'btn btn-link logout']
//                )
//                . Html::endForm()
//                . '</li>'
//            ),

        ],
    ]);
    NavBar::end();
    ?>


    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <?= Alert::widget() ?>


        <?= $content ?>
</section>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Азбука климата <?= date('Y') ?></p>

<!--        <p class="pull-right">--><?//= Yii::powered() ?><!--</p>-->
    </div>
</footer>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

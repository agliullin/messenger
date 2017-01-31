<?php

/* @var $this \yii\web\View */
/* @var $content string */

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
        'brandLabel' => 'Мессенджер',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            Yii::$app->user->identity->role == 2 ? (
                ['label' => 'Панель администратора', 'url' => ['/admin/index']]
            ) : ("...") ,
            ['label' => 'Главная', 'url' => ['/site/index']],
            Yii::$app->user->isGuest ? ( 
                ['label' => 'Регистрация', 'url' => ['/site/signup']]
            ) : (
                ['label' => 'Отправить сообщение', 'url' => ['/dialog/send']]
            ),
            Yii::$app->user->isGuest ? ( 
                    "..."
            ) : (
                ['label' => 'Диалоги', 'url' => ['/dialog/index']]
            ),
            Yii::$app->user->isGuest ? ( 
                    "..."
            ) : (
                ['label' => 'ЧС', 'url' => ['/site/blacklist']]
            ),
            Yii::$app->user->isGuest ? ( 
                    "..."
            ) : (
                ['label' => 'Групповые чаты', 'url' => ['/chat/index']]
            ),
            Yii::$app->user->isGuest ? ( 
            ['label' => 'Авторизация', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Выйти (' . Yii::$app->user->identity->name . ' '. Yii::$app->user->identity->surname. ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $this->render('flashes') ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Мессенджер <?= date('Y') ?>
        </p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

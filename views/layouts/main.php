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
        'brandLabel' => '<img src="/imgs/logo48.png">',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([ // 左边的菜单
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            ['label' => '首页', 'url' => ['/site/index']],
            ['label' => '文章', 'url' => ['/post/index']],
        ]
    ]);

    if (Yii::$app->user->isGuest) {
        $rightItems[] = ['label' => '注册', 'url' => ['/ucenter/signup']];
        $rightItems[] = ['label' => '登录', 'url' => ['/ucenter/login']];
    } else {
        $rightItems[] = [
            'label' => '<img src="/imgs/logo.png">',
            'linkOptions' => ['class'=>'avatar'],
            'url'=>['/ucenter/index'],
            'items' => [
                ['label' => '<i class="fa fa-user fa-fw"></i> 会员中心', 'url' => ['/ucenter/index']],
                ['label' => '<i class="fa fa-sign-out fa-fw"></i> 退出登录', 'url' => ['/ucenter/logout']],
            ]
        ];
    }
    echo Nav::widget([ // 右边的菜单
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => $rightItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
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

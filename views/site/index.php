<?php

/* @var $this yii\web\View */

use app\widgets\banner\BannerWidget;
use app\widgets\post\PostWidget;

$this->title = '博客-首页';
?>
<div class="row" style="padding-bottom: 10px;">
    <div class="col-lg-9">
        <?= BannerWidget::widget()?>
<div class="row" style="padding-top: 10px;">
    <?= PostWidget::widget() ?>
</div>
    </div>
    <div class="col-lg-3">
        22222
    </div>
</div>

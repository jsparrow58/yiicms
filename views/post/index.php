<?php
/**
 * @var $this \yii\web\View
 * User: JSparrow
 * DateTime: 2016/11/2 15:23
 * Created by PhpStorm.
 */
use app\widgets\post\PostWidget;
use yii\helpers\Html;

$this->title = '文章列表';

$this->params['breadcrumbs'][] = ['label'=>$this->title];
?>
<div class="row">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('新建文章', ['post/create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= PostWidget::widget() ?>
</div>

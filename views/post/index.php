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
    <div class="col-lg-9">
        <?= PostWidget::widget() ?>
    </div>
    <div class="col-lg-3">
        <div class="panel">
            <div class="panel-title">
                操作
            </div>
            <div class="panel-body">
                <?= Html::a('新建文章', ['post/create'], ['class' => 'btn btn-success btn-large', 'style'=>'width:100%;']) ?>
            </div>
        </div>

    </div>
</div>

<?php
/**
 * @var $this \yii\web\View;
 * @var $model \app\models\Post;
 * User: JSparrow
 * DateTime: 2016/11/3 13:45
 * Created by PhpStorm.
 */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label'=>'文章', 'url'=>['post/index']];
$this->params['breadcrumbs'][] = ['label'=>$this->title];
?>
<div class="row">
    <div class="col-lg-9">
        <div class="page-header">
            <h1><?= $this->title ?></h1>
            <span>作者：<?= $model->author->email ?></span>
            <span>发布日期： <?= date('Y-m-d H:i:s',$model->created_at) ?></span>
            <span>浏览：<?= $model->extends->browser ?>次</span>
        </div>
        <?= $model->content ?>
        <div class="tag">
<?php foreach ($model->postTags as $tag) {
    echo '<span> <a href="#">' . $tag->tag->tag_name . '</a></span>';
}
?>
        </div>
    </div>
    <div class="col-lg-3">

    </div>
</div>

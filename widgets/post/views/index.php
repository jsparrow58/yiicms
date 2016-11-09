<?php
/**
 *
 * @var $model
 * User: JSparrow
 * DateTime: 2016/11/3 15:46
 * Created by PhpStorm.
 */
use yii\helpers\Url;

/** @var \app\models\Post $item */
?>

<?php
/** @var \app\models\Post $item */
foreach ($model as $item) : ?>
<div class="post_block panel">
    <div class="content">
        <h2 class="panel-title">
            <a href="<?= Url::to(['post/view', 'id'=>$item->id]) ?>" target="_blank"><?= $item->title?></a>
        </h2>
        <div class="panel-body">
        <div class="col-lg-2"><img src="<?= $item->label_img ?>" alt="<?= $item->title ?>"></div><div class="col-lg-10 entry_summary"><?= $item->summary ?></div>
        </div>
        <div class="clearfix"></div>
        <div class="panel-footer">
            <span class="post_comment">
                <a class="grayline" title="" href="<?= Url::to(['post/view' , 'id'=>$item->id]) ?>#commentform">
                    <i class="fa fa-comments"></i> 评论(<?= isset($item->extends) ? $item->extends->comment: 0  ?>)</a>
            </span>
            <span class="post_view">
                <a class="grayline" href="<?= Url::to(['post/view', 'id'=>$item->id])?>">
                    <i class="fa fa-eye"></i>阅读(<?= isset($item->extends) ? $item->extends->browser: 0  ?>)</a>
            </span>
            <i class="fa fa-feed"></i>推荐(<?= isset($item->extends) ? $item->extends->praise: 0  ?>)
            发布于 <span class="postdate"><?= date('Y-m-d H:i:s',$item->created_at) ?></span></div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php endforeach; ?>
        <?php
        echo \yii\widgets\LinkPager::widget([
            'pagination'=>$data['page'],//分页类
        ]);
        ?>

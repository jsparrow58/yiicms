<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\PostForm
 * User: JSparrow
 * DateTime: 2016/11/2 16:01
 * Created by PhpStorm.
 */

use app\models\Category;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = '新建文章';

$this->params['breadcrumbs'][] = ['label'=>'文章', 'url'=>['post/index']];
$this->params['breadcrumbs'][] = ['label'=> $this->title];
?>
<div class="row">
    <?php if (Yii::$app->session->hasFlash('warning')) : ?>
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Warning!</strong> <?= Yii::$app->session->getFlash('warning') ?>
    </div>
    <?php endif; ?>
    <div class="col-lg-9">
        <div class="panel">
            <div class="panel-title box-title"><span><?= $this->title ?></span></div>
            <div class="panel-body box-body">
                <?php $form = ActiveForm::begin([
                    /*'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-1 control-label'],
                    ],*/
                ])?>

                <?= $form->field($model, 'title')->textInput(['maxLength'=>true]) ?>

                <?= $form->field($model, 'category')->dropDownList(Category::getCategoryArray(), ['prompt'=>'请选择栏目']) ?>

                <?= $form->field($model, 'label_img')->widget('app\widgets\file_upload\FileUpload',[
                    'config'=>[
                    //图片上传的一些配置，不写调用默认配置
                    ]
                ]) ?>

                <?= $form->field($model, 'content')->widget('app\widgets\ueditor\Ueditor',[
                    'options'=>[
                        'initialFrameHeight' => 450,
                    ]
                ]) ?>

                <?=
                $form->field($model, 'tags')->widget('app\widgets\tags\TagWidget') ?>

                <div class="form-group">
                    <?= Html::submitButton('发布',['class'=>'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel">
            <div class="panel-title box-title"><span>注意事项</span></div>
            <div class="panel-body box-body">
                <p>1. xfadfasdfasdfasdf</p>
                <p>2. xfadfasdfasdfasdf</p>
                <p>3. xfadfasdfasdfasdf</p>
                <p>4. xfadfasdfasdfasdf</p>
                <p>5. xfadfasdfasdfasdf</p>
            </div>
        </div>
    </div>
</div>

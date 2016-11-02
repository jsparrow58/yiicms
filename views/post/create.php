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
    <div class="col-lg-9">
        <div class="panel">
            <div class="panel-title box-title"><span><?= $this->title ?></span></div>
            <div class="panel-body box-body">
                <?php $form = ActiveForm::begin()?>

                <?= $form->field($model, 'title')->textInput(['maxLength'=>true]) ?>
                <?= $form->field($model, 'category')->dropDownList(Category::getCategoryArray(), ['prompt'=>'请选择栏目']) ?>
                <?= $form->field($model, 'label_img')->widget('app\widgets\file_upload\FileUpload',[
                    'config'=>[
                    //图片上传的一些配置，不写调用默认配置
                    ]
                ]) ?>
                <?= $form->field($model, 'summary')->textInput(['maxLength'=>true]) ?>
                <?= $form->field($model, 'content')->textarea() ?>
                <?= $form->field($model, 'tags')->textInput(['maxLength'=>true]) ?>

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

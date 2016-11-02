<?php
/**
 *
 * User: JSparrow
 * DateTime: 2016/11/2 15:21
 * Created by PhpStorm.
 */

namespace app\controllers;


use app\controllers\base\BaseController;
use app\models\Category;
use app\models\PostForm;

/**
 * 文章控制器
 * @package app\controllers
 */
class PostController extends BaseController
{
    public function actions()
    {
        return [
            'upload'=>[
                'class' => 'app\widgets\file_upload\UploadAction',     //这里扩展地址别写错
                'config' => [
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ]
        ];
    }

    /**
     * 说明:文章列表
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionCreate() {
        $model = new PostForm();
        Category::getCategoryArray();
        return $this->render('create', ['model' => $model]);
    }
}
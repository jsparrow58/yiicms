<?php
/**
 *
 * User: JSparrow
 * DateTime: 2016/11/2 15:21
 * Created by PhpStorm.
 */

namespace app\controllers;


use app\controllers\base\BaseController;
use app\models\PostForm;

/**
 * 文章控制器
 * @package app\controllers
 */
class PostController extends BaseController
{

    /**
     * 说明:文章列表
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionCreate() {
        $model = new PostForm();

        return $this->render('create', ['model' => $model]);
    }
}
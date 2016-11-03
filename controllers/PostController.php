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
            ],
            'ueditor'=>[
                'class' => 'app\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
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

    /**
     * 说明:文章创建
     * @return string
     */
    public function actionCreate() {
        $model = new PostForm();
        $model->setScenario(PostForm::SCENARIO_CREATE);
        if($model->load(\Yii::$app->request->post())) {
            if(!$model->create()) {
                \Yii::$app->session->setFlash('warning', $model->_lastError);
            } else {
                return $this->redirect(['post/view', 'id'=>$model->id]);
            }
        }
        return $this->render('create', ['model' => $model]);
    }

    /**
     * 说明: 查看文章
     */
    public function actionView($id) {
        $model = new PostForm();
        $data = $model->getViewById($id);


        return $this->render('view', ['model'=>$data]);
    }
}
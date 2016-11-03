<?php

namespace app\widgets\post;

use app\models\Post;
use app\models\PostForm;
use Yii;
use yii\base\Widget;
use yii\data\Pagination;
use yii\helpers\Url;

/**
 * 文章列表组件
 * @package app\widgets\post
 */
class PostWidget extends Widget {
    // 文章列表的标题
    public $title = '';

    // 显示条数
    public $limit = 6;

    // 是否显示更多
    public $more = true;

    // 是否显示分页
    public $page = false;

    /**
     * 说明:运行组件
     * @return string
     */
    public function run() {
        $curPage = Yii::$app->request->get('page', 1);
        // 查询条件
        $condition = ['=', 'status', Post::IS_VALID];
        $res = PostForm::getList($condition, $curPage, $this->limit);
        $result['title'] = $this->title?:'最新文章';
        $result['more'] = Url::to(['post/index']);
        $result['body'] = $res['data']?:[];
        if ($this->page) {
            $pages = new Pagination(['totalCount'=>$res['count'], 'pageSize'=>$res['pageSize']]);
            $result['page'] = $pages;
        }

        return $this->render('index', ['data' => $result]);
    }
}
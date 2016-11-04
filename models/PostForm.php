<?php
/**
 *
 * User: JSparrow
 * DateTime: 2016/11/2 15:53
 * Created by PhpStorm.
 */

namespace app\models;


use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\db\Query;
use yii\web\NotFoundHttpException;

class PostForm extends Model
{
    public $id;
    public $title;
    public $label_img;
    public $category;
    public $summary;
    public $content;
    public $tags;

    public $_lastError = '';

    /**
     * 定义场景
     * SCENARIO_CREATE 创建
     * SCENARIO_UPDATE 更新
     */
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /*
     * 定义事件
     * EVENT_AFTER_CREATE 创建完成事件
     * EVENT_AFTER_UPDATE 更新完成事件
     */
    const EVENT_AFTER_CREATE = "eventAfterCreate";
    const EVENT_AFTER_UPDATE = "eventAfterUpdate";

    /**
     * 说明:
     * @param array $condition
     * @param int $page
     * @param int $pageSize
     * @param array $orderBy
     * @return array
     */
    public static function getList($condition, $curPage=1, $pageSize=5, $orderBy = ['id'=>SORT_DESC])
    {
        $model = new Post();
        // 查询字符
        $select = ['id', 'title', 'summary', 'label_img', 'category', 'author_id', 'status', 'created_at', 'updated_at'];
        // 查询语句
        $query = $model->find()
            ->select($select)
            ->where($condition)
            ->with('postTags.tag', 'extends')
            ->orderBy($orderBy);
        $res = $model->getPages($query, $curPage, $pageSize);
        return $res;
    }

    public function rules()
    {
        return [
            [['title', 'content', 'category'], 'required'],
            [['category'], 'integer'],
            ['title', 'string', 'min'=>4, 'max'=>255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => '标题',
            'category' => '栏目',
            'label_img' => '标签图',
            'content' => '内容',
            'tags' => '标签',
        ];
    }


    /**
     * 说明:场景设置
     * @return array
     */
    public function scenarios()
    {
        $scenarios = [
            self::SCENARIO_CREATE => ['title','content', 'label_img', 'category', 'tags'],
            self::SCENARIO_UPDATE => ['title','content', 'label_img', 'category', 'tags'],
        ];
        return array_merge(parent::scenarios(), $scenarios);
    }


    /**
     * 说明:文章创建
     * @return bool
     */
    public function create() {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new Post();
            $model->setAttributes($this->attributes);
            $model->summary = $this->_getSummary();
            $model->status = Post::IS_VALID;
            $model->author_id = Yii::$app->user->identity->getId();
            $model->created_at = time();
            $model->updated_id = Yii::$app->user->identity->getId();
            $model->updated_at = time();
            if(!$model->save()) {
                throw new Exception('文章保存失败');
            }

            $this->id = $model->id;

            // 调用事件 处理文章创建结束后的事件
            $data = array_merge($this->getAttributes(), $model->getAttributes());
            $this->_eventAfterCreate($data);

            $transaction->commit();
            return true;
        } catch (Exception $exception) {
            $transaction->rollBack();
            $this->_lastError = $exception->getMessage();
            return false;
        }
    }


    /**
     * 说明:获取文摘要
     * @param int $start 开始
     * @param int $length 长度
     * @param string $char 字符编码
     * @return null|string
     */
    private function _getSummary($start=0, $length=90, $char='utf-8')
    {
        if(empty($this->content))
            return null;

        return (mb_substr(str_replace('&nbsp;', '',strip_tags($this->content)), $start, $length, $char));
    }

    /**
     * 说明:处理完成保存后的事件
     * @param $data
     */
    private function _eventAfterCreate($data) {
        // 添加事件
        $this->on(self::EVENT_AFTER_CREATE, [$this, '_eventAddTag'], $data);

        // 触发事件
        $this->trigger(self::EVENT_AFTER_CREATE);
    }

    /**
     * 说明:添加标签
     * @param $event
     * @throws Exception
     * @internal param $data
     */
    public function _eventAddTag($event) {
        //保存标签
        $tag = new TagForm();
        $tag->tags = $event->data['tags'];
        $tagids = $tag->saveTags();

        // 删除原先的关联系统
        PostTags::deleteAll(['post_id'=>$event->data['id']]);

        // 批量保存文章和标签的关联关系
        if(!empty($tagids)) {
            $row = [];
            foreach ($tagids as $k=>$id) {
                $row[$k]['post_id'] = $event->data['id'];
                $row[$k]['tag_id'] = $id;
            }
            $res = (new Query())->createCommand()
                ->batchInsert(PostTags::tableName(), ['post_id', 'tag_id'], $row)
                ->execute();
            if(!$res) {
                throw new Exception('关联关系保存失败');
            }
        }
    }

    public function getViewById($id)
    {
        $res = Post::find()->where(['id'=>$id])->one();
        if(!$res) {
            throw new NotFoundHttpException('文章不存在');
        }
        $model = new PostExtends();
        $model->upCounter(['post_id'=>$id], 'browser', 1);
        return $res;
    }
}
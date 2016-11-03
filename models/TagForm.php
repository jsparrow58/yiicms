<?php
/**
 *
 * User: JSparrow
 * DateTime: 2016/11/3 12:41
 * Created by PhpStorm.
 */

namespace app\models;


use yii\base\Exception;
use yii\base\Model;

class TagForm extends Model
{
    public $id;
    public $tags;

    public function rules() {
        return [
            ['tags', 'required'],
            ['tags', 'each', 'rule'=>['string']],
        ];
    }

    public function saveTags()
    {
        $ids = [];
        if(!empty($this->tags)) {
            foreach ($this->tags as $tag) {
                $ids[] = $this->saveTag($tag);
            }
        }
        return $ids;
    }

    private function saveTag($tag)
    {
        $model = new Tags();
        $res = $model->find()->where(['tag_name'=>$tag])->one();
        if(!$res) {
            $model->tag_name = $tag;
            $model->post_num = 1;
            if(!$model->save()) {
                throw new Exception('创建标签失败');
            }
            return $model->id;
        } else {
            $res->updateCounters(['post_num'=>1]);
        }
        return $res->id;
    }


}
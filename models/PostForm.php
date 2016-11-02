<?php
/**
 *
 * User: JSparrow
 * DateTime: 2016/11/2 15:53
 * Created by PhpStorm.
 */

namespace app\models;


use yii\base\Model;

class PostForm extends Model
{
    public $id;
    public $title;
    public $category;
    public $summary;
    public $content;
    public $tags;

    public $_lastError = '';

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
            'summary' => '摘要',
            'content' => '内容',
            'tags' => '标签',
        ];
    }


}
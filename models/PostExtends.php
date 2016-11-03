<?php

namespace app\models;

use app\models\base\BaseModel;
use Yii;

/**
 * This is the model class for table "{{%post_extends}}".
 *
 * @property integer $id
 * @property string $post_id
 * @property string $browser
 * @property string $collect
 * @property string $praise
 * @property string $comment
 *
 * @property Post $post
 */
class PostExtends extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_extends}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id'], 'required'],
            [['post_id', 'browser', 'collect', 'praise', 'comment'], 'integer'],
            [['post_id'], 'unique'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'browser' => 'Browser',
            'collect' => 'Collect',
            'praise' => 'Praise',
            'comment' => 'Comment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * 说明: 更新文章统计数据
     * @param $condition array
     * @param $attribute string
     * @param $num integer
     */
    public function upCounter($condition, $attribute, $num = 1)
    {
        $model = $this->findOne($condition);
        if(!$model) {
            $this->setAttributes($condition);
            $this->$attribute = $num;
            $this->save();
        } else {
            $model->updateCounters([$attribute=>$num]);
        }
    }
}

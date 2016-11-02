<?php

namespace app\models;

use app\models\base\BaseModel;
use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $postion
 * @property string $title
 * @property integer $hide
 * @property string $image
 * @property string $icon
 * @property integer $status
 *
 * @property Category $p
 * @property Category[] $categories
 * @property Post[] $posts
 */
class Category extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'postion', 'hide', 'status'], 'integer'],
            [['title', 'image', 'icon'], 'string', 'max' => 255],
            [['pid'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['pid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'postion' => 'Postion',
            'title' => 'Title',
            'hide' => 'Hide',
            'image' => 'Image',
            'icon' => 'Icon',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'pid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChilds()
    {
        return $this->hasMany(Category::className(), ['pid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['category' => 'id']);
    }

    /**
     * 获取所有分类
     * @return array
     */
    public static function getCategoryArray() {
        return static::find()->select(['title'])->indexBy('id')->column();
    }
}

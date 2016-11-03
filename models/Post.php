<?php

namespace app\models;

use app\models\base\BaseModel;
use Yii;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property integer $id
 * @property integer $category
 * @property string $title
 * @property string $summary
 * @property string $content
 * @property integer $author_id
 * @property integer $created_at
 * @property integer $updated_id
 * @property integer $updated_at
 * @property integer $status
 * @property string $label_img
 *
 * @property Comment[] $comments
 * @property Admin $author
 * @property Category $category0
 * @property Admin $updated
 * @property PostTags[] $postTags
 * @property PostExtends $extends
 */
class Post extends BaseModel
{
    const IS_VALID = 1; // 发布
    const NO_VALID = 0; // 未发布

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'author_id', 'created_at', 'updated_id', 'updated_at', 'status'], 'integer'],
            [['content'], 'required'],
            [['content'], 'string'],
            [['title', 'summary', 'label_img'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Admin::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category' => 'id']],
            [['updated_id'], 'exist', 'skipOnError' => true, 'targetClass' => Admin::className(), 'targetAttribute' => ['updated_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'title' => 'Title',
            'summary' => 'Summary',
            'content' => 'Content',
            'author_id' => 'Author ID',
            'created_at' => 'Created At',
            'updated_id' => 'Updated ID',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'label_img' => 'Label Img',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['postid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Admin::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory0()
    {
        return $this->hasOne(Category::className(), ['id' => 'category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdated()
    {
        return $this->hasOne(Admin::className(), ['id' => 'updated_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostTags()
    {
        return $this->hasMany(PostTags::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtends()
    {
        return $this->hasOne(PostExtends::className(), ['post_id' => 'id']);
    }


}

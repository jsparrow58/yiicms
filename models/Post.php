<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hs_post".
 *
 * @property string $id
 * @property string $category
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property string $author_id
 * @property string $created_at
 * @property string $updated_id
 * @property string $updated_at
 * @property integer $status
 *
 * @property Comment[] $comments
 * @property Admin $updated
 * @property Admin $author
 * @property Category $category0
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hs_post';
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
            [['title', 'tags'], 'string', 'max' => 255],
            [['updated_id'], 'exist', 'skipOnError' => true, 'targetClass' => Admin::className(), 'targetAttribute' => ['updated_id' => 'id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Admin::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category' => 'id']],
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
            'content' => 'Content',
            'tags' => 'Tags',
            'author_id' => 'Author ID',
            'created_at' => 'Created At',
            'updated_id' => 'Updated ID',
            'updated_at' => 'Updated At',
            'status' => 'Status',
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
    public function getUpdated()
    {
        return $this->hasOne(Admin::className(), ['id' => 'updated_id']);
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
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property string $id
 * @property string $content
 * @property integer $status
 * @property string $postid
 * @property string $uid
 * @property string $email
 * @property string $client_ip
 * @property string $client_time
 *
 * @property User $u
 * @property Post $post
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string'],
            [['status', 'postid', 'uid', 'client_ip', 'client_time'], 'integer'],
            [['email'], 'string', 'max' => 255],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['uid' => 'id']],
            [['postid'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['postid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'status' => 'Status',
            'postid' => 'Postid',
            'uid' => 'Uid',
            'email' => 'Email',
            'client_ip' => 'Client Ip',
            'client_time' => 'Client Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'postid']);
    }
}

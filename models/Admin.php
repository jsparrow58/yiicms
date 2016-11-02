<?php

namespace app\models;

use app\models\base\BaseModel;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property string $id
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $last_login_ip
 * @property string $last_login_time
 * @property string $password write-only password
 *
 * @property AdminLogin[] $adminLogins
 * @property Post[] $updatedPost
 * @property Post[] $posts
 */
class Admin extends BaseModel  implements IdentityInterface
{
    const ADMIN_ACTIVED = 1;
    const ADMIN_DISABLED = 0;
    public $password;
    public $repassword;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password_hash'], 'required'],
            [['email', 'password_reset_token'], 'unique'],
            ['email', 'email'],
            [['status', 'created_at', 'updated_at', 'last_login_ip', 'last_login_time'], 'integer'],
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['password', 'repassword', 'status'], 'required', 'on'=>'create'],
            ['repassword', 'compare', 'compareAttribute'=>'password', 'on'=>'create'],
            [['auth_key'], 'string', 'max' => 32],
        ];
    }

    /**
     * override
     * @param bool $insert
     * @return bool [type]         [description]
     * @internal param $ [type] $insert [description]
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert) {
                $this->created_at = time();
                $this->updated_at = time();
            } else {
                $this->updated_at = time();
            }
            return true;
        } else {
                return false;
        }
    }

    /**
     * 说明:
     * @return bool
     */
    public function beforeValidate(){
        if($this->scenario == 'create') {
            $this->setPassword($this->password);
            $this->generateAuthKey();
        }
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auth_key' => 'Auth Key',
            'password' => '密码',
            'repassword' => '检验密码',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => '电子邮箱',
            'status' => '状态',
            'created_at' => '注册日期',
            'updated_at' => '更新日期',
            'last_login_ip' => '登陆IP',
            'last_login_time' => '登陆时间',
        ];
    }

    /**
     * 说明:
     * @param int $idx
     * @return array
     */
    public function getStatusList($idx=-1) {
        $lst = [0=>'禁用', 1=>'正常'];
        return isset($lst[$idx]) ? $lst[$idx] : $lst;
    }

    /**
     * 说明:
     * @param $model \app\models\Admin;
     * @return mixed
     */
    public function getStatusText() {
        return $this->getStatusList($this->status);
    }

    public static function getAdminByEmail($email) {
        return static::findOne(['email'=>$email]);
    }

    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * 获取管理的登陆日志
     * @return \yii\db\ActiveQuery
     */
    public function getAdminLogins()
    {
        return $this->hasMany(AdminLogin::className(), ['uid' => 'id']);
    }

    /**
     * 获取更新的博客
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedPost()
    {
        return $this->hasMany(Post::className(), ['updated_id' => 'id']);
    }

    /**
     * 获取发表的文章
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['author_id' => 'id']);
    }

    /**
     * 通过用户id获取用户实例
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return Admin::findOne(['id'=>$id, ['status'=>self::ADMIN_ACTIVED]]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['password_reset_token'=>$token]);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() == $authKey;
    }

    public function setPassword($password){
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    private function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
}

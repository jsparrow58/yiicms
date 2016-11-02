<?php

namespace app\models;

use app\models\base\BaseModel;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $id
 * @property string $email
 * @property string $password
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $created_at
 * @property string $updated_id
 * @property string $updated_at
 * @property string $last_login_ip
 * @property string $last_login_time
 * @property integer $status
 *
 * @property Comment[] $comments
 * @property Login[] $logins
 */
class User extends BaseModel implements IdentityInterface
{
    const SCENARIO_REGISTER = 'register';
    const SCENARIO_LOGIN = 'login';

    public $verify; // 验证码
    public $password;
    public $repassword;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            ['email', 'email'],
            [['created_at', 'updated_at', 'last_login_ip', 'last_login_time', 'status'], 'integer'],
            [['email', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username', 'email', 'password_reset_token'], 'unique'],

            [['password', 'repassword'], 'required'],
            [['password', 'repassword'], 'string', 'min' => 6],
            ['repassword', 'compare', 'compareAttribute'=>'password'],
            ['verify', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'email' => '电子邮箱',
            'password' => '密码',
            'repassword' => '检验密码',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'last_login_ip' => 'Last Login Ip',
            'last_login_time' => 'Last Login Time',
            'status' => '状态',
            'verify' => '验证码',
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_LOGIN] = ['email', 'password'];
        $scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password', 'repassword', 'verify'];
        return $scenarios;
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            if($insert) {
                $this->created_at = time();
                $this->updated_at = time();
                $this->status = 1;
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            } else {
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }

    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id'=>$id, 'status'=>1]);
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


    public static function findByEmail($email) {
        return User::find()->where(['email'=>$email])->one();
    }

    /**
     * 说明:验证密码
     * @param $password
     * @return bool
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogins()
    {
        return $this->hasMany(Login::className(), ['uid' => 'id']);
    }

    public function save_login_info() {
        $this->last_login_ip = ip2long(Yii::$app->request->userIP);
        $this->last_login_time = time();
        return $this->save();
    }
}

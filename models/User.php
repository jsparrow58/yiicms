<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;

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
class User extends ActiveRecord implements IdentityInterface
{
	public $verify;
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
			[['verify', 'email', 'password'], 'required'],
			[['created_at', 'updated_id', 'updated_at', 'last_login_ip', 'last_login_time', 'status'], 'integer'],
			[['email', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
			[['password', 'auth_key'], 'string', 'max' => 32],
			[['email'], 'unique'],
			[['password_reset_token'], 'unique'],
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
			'email' => '电子邮箱',
			'password' => '密　　码',
			'auth_key' => 'Auth Key',
			'password_hash' => 'Password Hash',
			'password_reset_token' => 'Password Reset Token',
			'created_at' => 'Created At',
			'updated_id' => 'Updated ID',
			'updated_at' => 'Updated At',
			'last_login_ip' => 'Last Login Ip',
			'last_login_time' => 'Last Login Time',
			'status' => 'Status',
			'verify' => '验证码',
		];
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

	public static function findByUsername($username) {
		return User::find()->where(['username'=>$username])->one();
	}

	public function validatePassword($password) {
		return Yii::$app->security->validatePassword($password, $this->password);
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
}

<?php
/**
 * Created by PhpStorm.
 * User: jjxbo
 * Date: 2016/10/28
 * Time: 16:42
 */

namespace app\modules\admin\models;


use yii\base\Model;

/**
 * Class AdminLoginForm
 */
class AdminLoginForm extends Model
{
	public $email;
	public $password;
	public $verify;

	private $_admin = false;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['verify', 'email', 'password'], 'required'],
			['email', 'email'],
			['verify', 'captcha', 'captchaAction'=>'admin/common/captcha'],
			['password', 'validatepassword'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'password' => '密　　码',
			'verify' => '验证码',
			'email' => '电子邮箱',
		];
	}

	/**
	 * 实际的登陆操作
	 * @return bool
	 */
	public function login() {
		if($this->validate()){
			return \Yii::$app->user->login($this->getAdmin());
		}
		return false;
	}

	public function validatepassword($attribute, $params) {
		if (!$this->hasErrors()) {
			$admin = $this->getAdmin();

			if (!$admin || !$admin->validatePassword($this->password)) {
				$this->addError($attribute, '用户名或者密码错误');
			}
		}
	}

	public function getAdmin() {
		if($this->_admin === false) {
			$this->_admin = Admin::getAdminByEmail($this->email);
		}
		return $this->_admin;
	}
}
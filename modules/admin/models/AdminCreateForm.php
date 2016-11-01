<?php
/**
 * Created by PhpStorm.
 * User: jjxbo
 * Date: 2016/10/28
 * Time: 17:45
 */

namespace app\modules\admin\models;

use app\models\Admin;
use yii\base\Model;

/**
 * Class AdminCreateForm
 * @package app\modules\admin\models
 * @property \app\models\Admin $admin
 */
class AdminCreateForm extends Model
{
	public $email;
	public $password;
	public $repassword;
	public $status;

	public $admin = false;

	public function rules()
	{
		return [
			[['email', 'password', 'repassword', 'status'], 'required'],
			[['email'], 'string', 'max'=>255],
			[['email'], 'email'],
			[['password', 'repassword'], 'string', 'max'=>255, 'min'=>6],
			['repassword', 'compare', 'compareAttribute'=>'password'],
			['status', 'integer'],
		];
	}

	public function attributeLabels()
	{
		return [
			'email' => '电子邮箱',
			'password' => '密码',
			'repassword' => '校验密码',
			'status' => '管理员状态',
		];
	}

	public function getStatusList() {
		return [0=>'禁用', 1=>'正常'];
	}

	public function validate($attributeNames = null, $clearErrors = true)
	{
		if(parent::validate($attributeNames, $clearErrors)) {
			$this->admin = new Admin();
			$this->admin->password = $this->password;
			$this->admin->email = $this->email;
			$this->admin->status = $this->status;
			return $this->admin->validate();
		}
		return false;
	}


	public function save() {
		return $this->admin->save();
	}

}
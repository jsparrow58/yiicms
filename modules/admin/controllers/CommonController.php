<?php
/**
 * Created by PhpStorm.
 * User: jjxbo
 * Date: 2016/10/21
 * Time: 15:41
 */

namespace app\modules\admin\controllers;

use app\modules\admin\models\AdminLoginForm;
use yii\web\Controller;

class CommonController extends Controller
{
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'width' => 105,
				'height' => 34,
				'minLength' => 5,
				'maxLength' => 5,
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	public function actionLogin() {
		$this->layout = false;

		$model = new AdminLoginForm();
		if($model->load(\Yii::$app->request->post()) && $model->login()) {

		}

		return $this->render('login', ['model'=>$model]);
	}
}
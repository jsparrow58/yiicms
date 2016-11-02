<?php
/**
 *
 * User: JSparrow
 * DateTime: 2016/11/2 10:01
 * Created by PhpStorm.
 */

namespace app\controllers;


use app\models\LoginForm;
use app\models\User;
use Yii;
use yii\web\Controller;

class UcenterController extends Controller
{
    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * 说明:用户注册
     * @return string
     */
    public function actionSignup() {
        $user = new User();
        $user->scenario = User::SCENARIO_REGISTER;
        if($user->load(Yii::$app->request->post()) && $user->save() && Yii::$app->getUser()->login($user)) {
            return $this->goHome();//$this->redirect(['/site/index']);
        }
        return $this->render('signup', ['model'=>$user]);
    }


    /**
     * 说明:用户登录
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', ['model' => $model]);
    }

    /**
     * 说明:用户注销
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
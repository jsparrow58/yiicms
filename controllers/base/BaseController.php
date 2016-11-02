<?php
/**
 *
 * User: JSparrow
 * DateTime: 2016/11/2 15:18
 * Created by PhpStorm.
 */

namespace app\controllers\base;


use yii\web\Controller;

/**
 * 基础控制器
 * @package app\controllers\base
 */
class BaseController extends Controller
{
    public function beforeAction($action)
    {
        if(!parent::beforeAction($action)) {
            return false;
        }
        return true;
    }
}
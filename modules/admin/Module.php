<?php

namespace app\modules\admin;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

	public $layout = 'default';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
		\Yii::$app->errorHandler->errorAction = 'admin/common/error'; // 注意斜杠方向
		\Yii::$app->user->identityClass = 'app\models\admin';
        // custom initialization code goes here
    }
}

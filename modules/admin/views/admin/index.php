<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员设置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('新建管理员', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['attribute'=>'id', 'contentOptions'=>['style'=>'width:30px;'], 'filter'=>false],
            'email:email',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            [
                'attribute'=>'status',
                'value' => function($model) {return $model->getStatusText();},
            ],
            [
                'attribute'=>'created_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
                'contentOptions' => ['width'=>160]
            ],
            [
                'attribute'=>'updated_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
                'contentOptions' => ['width'=>160]
            ],
            [
                'attribute'=>'last_login_ip',
                'value' => function($model) {return long2ip($model->last_login_ip);},
                'contentOptions' => ['width'=>160]
            ],
            [
                'attribute'=>'last_login_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
                'contentOptions' => ['width'=>160]
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

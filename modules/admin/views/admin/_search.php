<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\AdminSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-search">

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

	<?php //$form->field($model, 'id') ?>

	<?php //$form->field($model, 'auth_key') ?>

	<?php //$form->field($model, 'password_hash') ?>

	<?php //$form->field($model, 'password_reset_token') ?>

	<?php echo $form->field($model, 'email')->textInput() ?>

	<?php echo $form->field($model, 'status')->dropDownList($model->getStatusList(), ['prompt'=>'选择状态']) ?>

	<?php // echo $form->field($model, 'created_at') ?>

	<?php // echo $form->field($model, 'updated_at') ?>

	<?php // echo $form->field($model, 'last_login_ip') ?>

	<?php // echo $form->field($model, 'last_login_time') ?>

	<div class="form-group">
		<?= Html::submitButton('查找', ['class' => 'btn btn-primary']) ?>
		<?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>

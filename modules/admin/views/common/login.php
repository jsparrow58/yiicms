<?php
/* @var $this yii\web\View */
/* @var $model app\models\AdminLoginForm */

use app\assets\AppAsset;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

AppAsset::register($this);
$this->title = '华商工作平台';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>

	<meta charset="<?= Yii::$app->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<meta name="keywords" content="">
	<meta name="description" content="">
	<link rel="shortcut icon" href="<?php echo  Yii::$app->request->baseUrl?>/favicon.ico">
	<?php $this->head() ?>
	<link href="<?php echo  Yii::$app->request->baseUrl?>/assets/css/font-awesome.css?v=4.3.0" rel="stylesheet">
	<link href="<?php echo  Yii::$app->request->baseUrl?>/assets/css/animate.min.css" rel="stylesheet">
	<link href="<?php echo  Yii::$app->request->baseUrl?>/assets/css/style.css?v=2.2.0" rel="stylesheet">
</head>

<body class="gray-bg">
<?php $this->beginBody() ?>
<div class="middle-box text-center loginscreen  animated fadeInDown">
	<div>
		<div><h1 class="logo-name">HS</h1></div>
		<h3><?= Html::encode($this->title) ?></h3>
		<?php $form = ActiveForm::begin([
			'fieldConfig' => [
				'template' => '{beginWrapper}{input}{hint}{error}{endWrapper}',
			]
		]);?>
		<?php echo $form->field($model, 'email', [
			'inputOptions'=>[
				'placeholder' => $model->getAttributeLabel('email'),
			]
		])->textInput(['autofocus'=>true]); ?>

		<?php echo $form->field($model, 'password', [
			'inputOptions' => [
				'placeholder' => $model->getAttributeLabel('password'),
			]
		])->passwordInput(); ?>

		<?php echo $form->field($model, 'verify')->widget(Captcha::className(), [
			'captchaAction' => 'common/captcha',
			'options' => [
				'placeholder' => $model->getAttributeLabel('verify'),
				'class' => 'form-control'
			],
			'template'=>
				'<div class="row">
					<div class="col-lg-7">{input}</div>
					<div class="col-lg-5">{image}</div>
				</div>',
			'imageOptions'=>[
				'style' => 'cursor:pointer'
			]
		]); ?>
			<label class="check-tips error"></label>
			<button type="submit" class="btn btn-primary block full-width m-b">登 录</button>
		<?php \yii\bootstrap\ActiveForm::end(); ?>
	</div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
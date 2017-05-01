<?php

use app\assets\ShortenAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = Yii::$app->name;

ShortenAsset::register($this);
?>
<div class="site-index">
	<h1><?= Yii::$app->name ?></h1>
	
	<p><?= Yii::t('app', 'URL shortener service.') ?> <?= Yii::t('app', 'Input your link to the field below.') ?></p>
	
	<?php $form = ActiveForm::begin([
		'action' => ['site/shorten'],
		'validateOnSubmit' => false,
		'options' => [
			'class' => 'shorten-form',
		],
	]) ?>
		<?= $form->field($model, 'link')->textInput()->label(false) ?>
		
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Shorten URL'), ['class' => 'btn btn-primary']) ?>
		</div>
		
	<?php ActiveForm::end() ?>
	
	<div class="shorten-result"></div>
</div>

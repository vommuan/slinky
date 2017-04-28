<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
	<h1>Slinky</h1>
	
	<p>URL Shortener service. Input your link to the field below.</p>
	
	<?php $form = ActiveForm::begin() ?>
		<?= $form->field($model, 'link')->textInput()->label(false) ?>
		
	<?php ActiveForm::end() ?>
</div>

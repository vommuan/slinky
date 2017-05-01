<?php

use yii\helpers\Url;

?>

<div class="alert alert-success" role="alert">
	<b><?= Yii::t('app', 'Copy your short link') ?>:</b> <?= Url::to(['/' . $shortLink], true) ?>
</div>
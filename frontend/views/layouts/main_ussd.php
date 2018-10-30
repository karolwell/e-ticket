<?php

use frontend\assets\AppAsset;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= Yii::$app->charset ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
		<title>USSD</title>
		<?php $this->head() ?>
	</head>
	<?php $this->beginBody() ?>
		<body style="margin:0% 0% 0% 0%; ">

			<!-- wrapper -->
			<!--<div id="wrapper">-->
				<?php  
						echo $content ;
				?>     
			<!--</div>-->
		</body>
	<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\Ticket */
/**/

$this->title = 'Crée un ticket';
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="ticket-create" >

	<!-- <h1><?= Html::encode($this->title) ?></h1> -->

	<?= $this->render('_form', [
		'model' => $model,
		'activites' => $activites,
		'validites' => $validites,
		//'typetickets' => $typetickets,
	]) ?>

</div>

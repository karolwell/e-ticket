<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\Ticket */

$this->title = 'Mise à jour Ticket: ' . $model->activite->designation.'|'.$model->designation;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
//$this->params['breadcrumbs'][] = 'Mise à jour';
$this->params['breadcrumbs'][] = ['label' => $model->activite->designation.'|'.$model->designation, 'url' => ['view', 'id' => $model->id]];
?>
<div class="ticket-update">

	<!-- <h1><?= Html::encode($this->title) ?></h1> -->

	<?= $this->render('_form', [
		'model' => $model,
		'activites' => $activites,
		'typetickets' => $typetickets,
		'validites' => $validites,
	]) ?>

</div>

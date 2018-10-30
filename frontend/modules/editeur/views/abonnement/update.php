<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\Abonnement */

$this->title = 'Mise à jour abonnement: ' . $model->typeAbonnement->designation;
$this->params['breadcrumbs'][] = ['label' => 'Abonnements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<h6 class="text-muted text-normal text-uppercase"><?= Html::encode($this->title) ?></h6>
<hr class="margin-bottom-1x">
<div class="abonnement-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\Activite */

$this->title = 'Mise à jour Activite: ' . $model->designation;
$this->params['breadcrumbs'][] = ['label' => 'Activites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->designation, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'mise à jour';
?>
<div class="activite-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'categorieactivites' => $categorieactivites,
    ]) ?>

</div>

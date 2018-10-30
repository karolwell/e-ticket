<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\Abonnement */

$this->title = 'Create Abonnement';
$this->params['breadcrumbs'][] = ['label' => 'Abonnements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h6 class="text-muted text-normal text-uppercase"><?= Html::encode($this->title) ?></h6>
<hr class="margin-bottom-1x">
<div class="abonnement-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

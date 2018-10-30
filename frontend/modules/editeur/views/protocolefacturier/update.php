<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\ProtocoleFacturier */

$this->title = 'Update Protocole Facturier: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Protocole Facturiers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="protocole-facturier-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

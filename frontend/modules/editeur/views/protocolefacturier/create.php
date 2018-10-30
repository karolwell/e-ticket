<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\ProtocoleFacturier */

$this->title = 'Create Protocole Facturier';
$this->params['breadcrumbs'][] = ['label' => 'Protocole Facturiers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="protocole-facturier-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

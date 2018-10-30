<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\AbonnementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="abonnement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'editeurId') ?>

    <?= $form->field($model, 'type_abonnementId') ?>

    <?= $form->field($model, 'date_detut_abonnement') ?>

    <?= $form->field($model, 'date_fin_abonnement') ?>

    <?php // echo $form->field($model, 'etat') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

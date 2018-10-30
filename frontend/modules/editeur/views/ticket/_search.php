<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\TicketSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ticket-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'designation') ?>

    <?= $form->field($model, 'prix') ?>

    <?= $form->field($model, 'nombre_ticket') ?>

    <?= $form->field($model, 'type_ticketId') ?>

    <?php // echo $form->field($model, 'activiteId') ?>

    <?php // echo $form->field($model, 'periode') ?>

    <?php // echo $form->field($model, 'validiteId') ?>

    <?php // echo $form->field($model, 'duree_validite') ?>

    <?php // echo $form->field($model, 'nombre_validation') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

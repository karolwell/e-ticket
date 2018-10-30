<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\ActiviteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activite-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'designation') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'editeurId') ?>

    <?= $form->field($model, 'categorie_activiteId') ?>

    <?php // echo $form->field($model, 'lieu') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'heure') ?>

    <?php // echo $form->field($model, 'reference') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'latitude') ?>

    <?php // echo $form->field($model, 'longitude') ?>

    <?php // echo $form->field($model, 'etat') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'date_create') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'date_update') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

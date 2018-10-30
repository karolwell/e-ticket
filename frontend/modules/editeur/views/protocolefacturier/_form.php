<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\ProtocoleFacturier */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="protocole-facturier-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userId')->textInput() ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ftp_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ftp_username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ftp_password')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

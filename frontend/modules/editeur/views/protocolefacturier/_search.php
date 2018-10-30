<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\ProtocoleFacturierSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="protocole-facturier-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userId') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'ftp_ip') ?>

    <?= $form->field($model, 'ftp_username') ?>

    <?php // echo $form->field($model, 'ftp_password') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

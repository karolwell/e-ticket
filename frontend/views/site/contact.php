<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = 'Contactez-nous';
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="padding-top-1x padding-bottom-7x container"> 
<div class="site-login" style="margin-left: 5%; margin-bottom: -10%; margin-top: 2%; ">
    <h1 style="color:#666666;"><?= Html::encode($this->title) ?></h1>

    <!-- <h4 class="text text-info">Veuillez renseigner tous les champs</h4> -->

    <div class="row" style="margin-top: -1%;">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'name')->textInput(['placeholder'=>'Nom'])->Label(''); ?>
                <?= $form->field($model, 'email')->textInput(['placeholder'=>'E-mail'])->Label(''); ?>
                <?= $form->field($model, 'subject')->textInput(['placeholder'=>'Titre'])->Label(''); ?>
                <?= $form->field($model, 'body')->textArea(['rows' => 6,'placeholder'=>'Message...'])->Label(''); ?>
                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-6">{image}</div><div class="col-lg-6">{input}</div></div>',
                ])->Label(''); ?>
                <div class="form-group">
                    <?= Html::submitButton('Envoyer', ['class' => 'btn btn-outline-primary col-lg-5', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>

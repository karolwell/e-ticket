<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Connexion';
//$this->params['breadcrumbs'][] = $this->title;
?>

<section class=" container padding-top-1x" style="padding: 0px 0px 0px 0px;">
  <!-- <h3 class="text-center mb-30">Top Categories</h3> -->
  <div class="row">
    <?= $this->render('evenement') ?>

    <div class="padding-top-1x padding-bottom-7x col-md-9"> 
        <div class="site-login" style="margin-left: 7%; margin-bottom: -10%; margin-top: 2%; ">
            <h1 style="color:#666666;"><?= Html::encode($this->title) ?></h1>

            <!-- <h4 class="text text-info">Veuillez renseigner tous les champs</h4> -->

            <div class="row" style="margin-top: -1%;">
                <div class="col-lg-5">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                    <?= $form->field($model, 'username')->textInput(['placeholder'=>'Login'])->Label(''); ?>
                    <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Password'])->Label('') ?>
                    <?php //echo $form->field($model, 'rememberMe')->checkbox()->Label('') ?>
                    <div style="color:#999;margin:1em 0">
                        Mot de passe oublier? <?= Html::a('Réinitialiser', ['site/request-password-reset']) ?>.
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('Valider', ['class' => 'btn btn-outline-primary col-lg-5', 'name' => 'login-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</section>


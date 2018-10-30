<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Inscription';
//$this->params['breadcrumbs'][] = $this->title;
?>

<script type="text/javascript">

  function showAbonnement(){

    var value = $('#typeuser').val();

    if(value=="editeur"||value=="Editeur"){
      $('#typeabonnement').show();
    }else{
     $('#typeabonnement').hide();
   }
 }

 function print_file(){

    var value = $('#file-input').val();
    $('#logo').text("");
    $('#logo').text(value);
 }

  function submited(){
    showAbonnement();
    print_file();

 }


</script>


<div class="padding-top-1x padding-bottom-7x container"> 
  <div class="site-login" style="margin-left: 5%; margin-top: 2%; ">

    <!-- <h4 class="text text-info">Veuillez renseigner tous les champs</h4> -->

    <div class="row" style="margin-top: 4%; margin-bottom: -4%;">
      <?= $this->render('evenement') ?>
      <div class="col-lg-5" style="margin-left: 7%;">
       <h1 style="color:#666666;"><?= Html::encode($this->title) ?></h1>
       <?php $form = ActiveForm::begin(['id' => 'form-signup','options' => ['enctype' => 'multipart/form-data']]); ?>
       <div class="form-group row">
        <select id="typeuser" name="type_userId" class="form-control normal-rounded-input" id="select-input" onchange="showAbonnement()">
          <option>Choose option...</option>
          <?php foreach ($typeusers as $typeuser): ?>
            <option value="<?= $typeuser->designation ?>"><?= $typeuser->designation ?></option>
          <?php endforeach ?>
        </select>
      </div>

      <div id="typeabonnement" class="form-group row" style="display: none;">
        <select name="type_abonnementId" class="form-control normal-rounded-input" id="select-input">
          <option>Choose option...</option>
          <?php foreach ($typeabonnements as $typeabonnement): ?>
            <option value="<?= $typeabonnement->id ?>"><?= $typeabonnement->designation ?></option>
          <?php endforeach ?>
        </select>
        <div class="custom-file" style="margin-top: 20px;">
         <!--  <input class="custom-file-input" type="file" id="file-input" name="imageFile" onchange="print_file();" /> -->
          <?= $form->field($model, 'imageFile')->fileInput(['id'=>'file-input', 'class'=>'custom-file-input', 'onchange'=>'print_file();']) ?>
          <label class="custom-file-label" for="file-input" id="logo">Charger un logo...</label>
        </div>
      </div>
      <?= $form->field($model, 'username')->textInput(['placeholder'=>'Nom', 'class'=>'form-control'])->Label(''); ?>
      <?= $form->field($model, 'email')->textInput(['placeholder'=>'E-mail'])->Label(''); ?>
      <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Mot de passe'])->Label(''); ?>
      <?= $form->field($model, 'password_confirm')->passwordInput(['placeholder'=>'Confirmer le mot de passe'])->Label(''); ?>
      <div class="form-group">
        <?= Html::submitButton('Valider', ['class' => 'btn btn-outline-primary col-lg-5', 'name' => 'login-button', 'onclick' => 'submited()']) ?>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>
</div>

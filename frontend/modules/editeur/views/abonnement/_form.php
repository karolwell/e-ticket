<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\editeur\models\TypeAbonnement;

/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\Abonnement */
/* @var $form yii\widgets\ActiveForm */

$typeabonnements = TypeAbonnement::find()->where(['etat'=>1])->orderby('prix')->all();
$datedebut = date('d/m/Y');
$datefin  = date('d/m/Y', strtotime('+365 day'));
?>

<script type="text/javascript">

  function describe(id){
    $("#description_"+id).show();
  }

  function hide_description(id){
    $("#description_"+id).hide();
  }

</script>

<div class="abonnement-form col-md-7">

  <?php $form = ActiveForm::begin(); ?> 

  <!-- <?= $form->field($model, 'editeurId')->textInput() ?> -->
  <br>

  <div onmouseleave="hide_description();" class="col-sm-12 form-group">

    <?php foreach ($typeabonnements as $typeabonnement): ?>
      <div class="custom-control custom-radio col-sm-3 text-center " style="">
        <input onmouseleave="hide_description(<?= $typeabonnement->id ?>);" onmouseover="describe(<?= $typeabonnement->id ?>)" class="custom-control-input" type="radio" id="<?= $typeabonnement->id ?>" name="Abonnement[type_abonnementId]" value="<?= $typeabonnement->id ?>" />
        <label onmouseleave="hide_description(<?= $typeabonnement->id ?>);" onmouseover="describe(<?= $typeabonnement->id ?>);"  class="custom-control-label" for="<?= $typeabonnement->id ?>"> <span style="font-weight: bold; font-size: 15px;"><?= $typeabonnement->designation ?></span> </label>
      </div>
    <?php endforeach ?>
  </div>

  <div class="col-sm-12  form-group">

    <?php foreach ($typeabonnements as $typeabonnement): ?>
      <div id="description_<?= $typeabonnement->id ?>" style="display: none; z-index: 2000; border: 1px solid #fff; border-radius: 20px; box-shadow: 1px 2px 2px #ccc; font-size: 15px; margin-top: -20px;" class="col-sm-12 'btn btn-outline-primary">
      <div class="col-md-3">
        <img class="" src="<?php echo Yii::$app->homeUrl.'images/abonnements/'.strtolower($typeabonnement->designation).'-card.jpg' ?>" alt="Card image" style="height:80px; width:100%;" />
      </div>
      <div class="col-md-9">
        <table class="table table-hover table-stripped table-condensed">
          <tr><th>Abonnement</th><td><?= $typeabonnement->designation ?></td></tr>
          <tr><th>coût</th><td><?= $typeabonnement->prix ?></td></tr>
          <tr><td colspan="2"><?= $typeabonnement->description ?></td></tr>
        </table> 
      </div>
         
      </div>
    <?php endforeach ?>
  </div>

  <div class="form-group col-sm-12 ">
    <div class="">
     <?= $form->field($model, 'date_detut_abonnement')->textInput(["placeholder"=>"Date début","type"=>"","value"=>$datedebut,"readonly"=>true,"class"=>"form-control"])->label("Date debut") ?>
   </div>
 </div>

 <div class="form-group col-sm-12 ">
  <div class="">
   <?= $form->field($model, 'date_fin_abonnement')->textInput(["placeholder"=>"Date début","type"=>"","value"=>$datefin,"readonly"=>true,"class"=>"form-control"])->label("Date fin") ?>
 </div>
</div>

<!-- <?= $form->field($model, 'etat')->textInput() ?> -->

<div class="form-group col-md-2">
  <?= Html::submitButton($model->isNewRecord ? 'Souscrire' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-outline-primary' : 'btn btn-outline-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>

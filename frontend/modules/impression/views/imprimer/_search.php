<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\AbonnementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<script type="text/javascript">

  function search(){

    $('#resultat').hide();
    $('#loader').show();

    var input = {};
    input.codes = $('#codes').val();
    var url = "<?php echo Yii::$app->homeUrl ?>impression/imprimer/search";


    $.ajax({
      url: url,
      type: "POST",
      data: {
        input: input,
      },
      success: function (data) {
        $('#loader').hide();
        $('#resultat').html("");
        $('#resultat').html(data);
        $('#resultat').show();



      }
    });

//JsBarcode(".barcode").init();
}

</script>

<div class="row"> 

  <div class="abonnement-search col-md-12">

    <?php // echo $form->field($model, 'etat') ?>

    <div class="form-group">
     <input id="codes" class="form-control form-control-lg col-md-10" id="large-pill-input" placeholder="Code ..." type="text" style="margin-left: 20px;" required="">
     <button class="btn btn-primary col-md-1" onclick="search();" style="margin-left: 20px;"> <i class="fa fa-search"></i> </button>
   </div>
   <br><br>
 </div>  

 <center id="loader" style="display:none; margin-top: 50px;" class="col-md-12">
  <img style="width: 60% height: 100px;"  src="<?php echo Yii::$app->homeUrl ?>images/loader.gif"  />
  <img style="width: 60% height: 100px;"  src="<?php echo Yii::$app->homeUrl ?>images/loader.gif"  />
</center>

<div id="resultat" class="col-md-12">


</div>

</div>


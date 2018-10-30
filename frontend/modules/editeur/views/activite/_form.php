<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\editeur\models\CategorieActivite;

/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\Activite */
/* @var $form yii\widgets\ActiveForm */
?>

<script type="text/javascript">

  function select_valide(){

    var arrays = ["#categorie_activite"];
        //var inits = ["Activite ...", "Type ticket ...", "Validite ..."];
        var bol = 'true';

        $.each(arrays, function(i, val) {

          if($(val).val()=='...'){

            bol ='false';

          }
        });
        return bol;
        
      }

      function input_valide(){
        var bol = 'true';
        $("#myform input[type='text'], #myform input[type='number']").each(function () {
          if($(this).val() === '') {
            bol = 'false';
          }
        });
        return bol;
      }



      function suivant(){

        var bol1 = select_valide();
        var bol2 = input_valide();
        //alert(bol1+'/'+bol2);
        $('#alerte').hide();
        if(bol1=='true' && bol2=='true'){
          $('#libelle_etape').text('');
          $('#libelle_etape').text('Etape 2');
          $('#etape1').hide('2000');
          $('#etape2').show('2000');
        }else{
          $('#alerte').addClass('alert alert-danger').show().text('Veuillez renseignez correctement le formulaire');
        }
      }


      function precedent(){
        $('#libelle_etape').text('');
        $('#libelle_etape').text('Etape 1');
        $('#etape2').hide('2000');
        $('#etape1').show('5000');
      }

      function print_file(){

        var value = $('#file-input').val();
        $('#image').text("");
        $('#image').text(value);
      }


    </script>


    <div id="alerte" class="col-md-12" style="margin-top: 5px; display: none;"></div>

    <div id="" class="col-md-12" style="margin-top: 10px;"></div>

    <div class="col-md-9">
      <h6 class="text-muted text-normal text-uppercase"><?= Html::encode($this->title) ?></h6>
      <hr class="margin-bottom-1x">
    </div>

    <div class="col-md-3">

      <p>
        <?= Html::Button('Etape 1', ['id' => 'libelle_etape','onclick' =>'precedent();','class' => 'btn btn-primary']) ?>

      </p>

    </div>

    <div class="ticket-form ">
      <div id="etape1" class=" col-md-7" style="border-right: solid 1px #FFF; padding-right: 25px;">

        <?php $form = ActiveForm::begin(['id'=>'myform']); ?> 

        <div class="form-group row">
          <label>Catégorie d'activité</label>
          <select id="categorie_activite" name="Activite[categorie_activiteId]" class="form-control normal-rounded-input" id="select-input">
            <option>...</option>
            <?php foreach ($categorieactivites as $categorieactivite): ?>
              <option value="<?= $categorieactivite->id ?>"><?= $categorieactivite->designation ?></option>
            <?php endforeach ?>
          </select>
        </div>

        <div class="custom-file" style="margin-left: -20px; margin-top:-10px;">
        <?php if (!$model->isNewRecord): ?>
         <img class="" src="<?php echo Yii::$app->homeUrl.'images/activites/'.$model->image ?>" alt="Card image" style="height:200px; width:100%;" />
       <?php endif ?>
         <div class="custom-file" style="margin-top: 20px;">
           <!--  <input class="custom-file-input" type="file" id="file-input" name="imageFile" onchange="print_file();" /> -->
           
           <?= $form->field($model, 'imageFile')->fileInput(['id'=>'file-input', 'class'=>'custom-file-input', 'onchange'=>'print_file();']) ?>
           <label class="custom-file-label" for="file-input" id="image">Charger une image ...</label>
         </div>

         <?= $form->field($model, 'designation')->textInput(['maxlength' => true]) ?>

         <?= $form->field($model, 'lieu')->textInput(['maxlength' => true]) ?>

         <div class="form-group">
          <br>
          <?= Html::Button('Suivant <i class="fa fa-arrow-right"></i>', [ 'onclick' =>'suivant();','class' =>'btn btn-outline-primary col-md-5' ]) ?>
        </div>

      </div>
    </div>



    <div class="col-md-7" id="etape2" style="display: none;">

      <div class="" style="margin-left: -15px;">
<!--         <div class="col-sm-12">
          <label class="" for="file-input" id="">Début</label>
        </div> -->
        <div class="col-sm-12 form-group">
        <div class="col-sm-6">
          <?= $form->field($model, 'datedebut')->textInput(["placeholder"=>"Datedebut","type"=>"date","class"=>"form-control"])->label('Début') ?>
        </div>
        <div class="col-sm-6">
          <?= $form->field($model, 'heuredebut')->textInput(["placeholder"=>"Heuredebut","type"=>"time","class"=>"form-control", "value"=>"00:00:00"])->label('..') ?>
        </div>
        </div>

       <!--  <div class="col-sm-12">
          <label class="" for="file-input" id="">Fin</label>
        </div> -->
        <div class="col-sm-12">
        <div class="col-sm-6">
          <?= $form->field($model, 'datefin')->textInput(["placeholder"=>"Datefin","type"=>"date","class"=>"form-control"])->label('Fin') ?>
        </div>
        <div class="col-sm-6">
          <?= $form->field($model, 'heurefin')->textInput(["placeholder"=>"Heurefin","type"=>"time","class"=>"form-control", "value"=>"00:00:00"])->label('...') ?>
        </div>
        </div>
        <div class="col-sm-12">
          <?= $form->field($model, 'description')->textArea(["placeholder"=>"Description","class"=>"form-control"])->label() ?>
        </div>
      </div>
      <br/><br/>
      <div class="form-group" style="margin-top: 50px;">

        <?= Html::Button('<i class="fa fa-arrow-left"></i> precedent', ['onclick' =>'precedent();','class' => 'btn btn-outline-primary col-md-5']) ?>
        <?= Html::submitButton('Valider', ['class' => 'btn btn-outline-success col-md-6' ]) ?>
      </div>
    </div>

    <?php ActiveForm::end(); ?>
  </div>




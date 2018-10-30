<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
/**/
?>


<script type="text/javascript">

    function select_valide(){

        var arrays = ["#activite", "#typeticket", "#validite"];
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
        $('#alerte').hide();
        if(bol1=='true' && bol2=='true'){
            $('#libelle_etape').text('');
            $('#libelle_etape').text('Etape 2');
            $('#etape1').hide('2000');
            $('#etape2').show('2000');
            $('#alerte').hide();
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

    function showInput_(){

        var v = $('#activite').val();

        var value = v.split('-')[1];

        if(value=='parking'){
            $('#duree_validite').show('');
        }else{
            $('#duree_validite').hide('');
        }

    }


    function showInput2(){

        var v = $('#validite').val();

        var value = v.split('-')[1];

        //alert(value);

        if(value=='usage unique'){
            flip_duree();
            $('#nombre_validation input').attr('type', 'hidden');
            $('#periode input').attr('type', 'hidden');
            $('#nombre_validation').hide('');
            $('#periode').hide('');
            $('#duree_validite input').attr('type', 'range');
            $('#duree_validite').show('');
        }

        if(value=='usage unique avec periode'){
            flip_duree();flip_periode();
            $('#nombre_validation input').attr('type', 'hidden');
            $('#nombre_validation').hide('');
            $('#periode input').attr('type', 'range');
            $('#duree_validite input').attr('type', 'range');
            $('#periode').show('');
            $('#duree_validite').show('');
        }

        if(value=='usage multiple'){
            flip_duree();flip_nombre();
            $('#periode input').attr('type', 'hidden');
            $('#periode').hide('');
            $('#nombre_validation input').attr('type', 'range');
            $('#duree_validite input').attr('type', 'range');
            $('#nombre_validation').show('');
            $('#duree_validite').show('');
        }

        if(value=='usage multiple avec periode'){
            flip_duree();flip_nombre();flip_periode();
            $('#periode input').attr('type', 'range');
            $('#nombre_validation input').attr('type', 'range');
            $('#duree_validite input').attr('type', 'range');

            $('#periode').show('');
            $('#nombre_validation').show('');
            $('#duree_validite').show('');
        }

        if(!value){

            $('#periode input').attr('type', 'hidden');
            $('#nombre_validation input').attr('type', 'hidden');
            $('#duree_validite input').attr('type', 'hidden');

            $('#periode').hide('');
            $('#nombre_validation').hide('');
            $('#duree_validite').hide('');
        }

    }

    function print_file(){

        var value = $('#file-input').val();
        $('#logo').text("");
        $('#logo').text(value);
    }

    function flip_duree(){

        var d = $('#duree').val();
        var e = Math.trunc(d/30)  ;
        var r = d%30 ;

        if(e<1){
         $('#r').text('');
         $('#r').text(d+'J');
     }

     if(e>=1 && r==0){
        $('#r').text('');
        $('#r').text(e+'M');
    }

    if(e>=1 && r!=0){
        $('#r').text('');
        $('#r').text(e+'M '+r+'J');
    }


}

function flip_nombre(){

    var d = $('#nombre').val();
    $('#n').text('');
    $('#n').text(d+'x');
}

function flip_periode(){

    var d = $('#temps').val();
    var e = Math.trunc(d/60)  ;
    var r = d%60 ;

    if(e<1){
     $('#t').text('');
     $('#t').text(d+'Min');
 }

 if(e>=1 && r==0){
    $('#t').text('');
    $('#t').text(e+'H');
}

if(e>=1 && r!=0){
    $('#t').text('');
    $('#t').text(e+'H '+r+'Min');
}

}


</script>

<div id="alerte" class="col-md-12 alert" style="margin-top: 5px;  display: none;"></div>
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

<div class="ticket-form" style="margin-top: -10px;">
    <div id="etape1" class=" col-md-7" style="border-right: solid 1px #FFF; padding-right: 25px;">

        <?php $form = ActiveForm::begin(['id'=>'myform']); ?> 

        <!-- <?= $form->field($model, 'activiteId')->textInput() ?> -->

        <div class="form-group row">
            <label>Activités</label>
            <select id="activite" name="activiteId" class="form-control normal-rounded-input" id="select-input" onchange="showInput1()">
                <?php if (!$model->isNewRecord): ?>
                  <option value="<?= $model->activite->id.'-'.$model->activite->categorieActivite->designation ?>"><?= $model->activite->designation ?></option>
              <?php else: ?>
                  <option>...</option>
              <?php endif ?>
              <?php foreach ($activites as $activite): ?>
                <option value="<?= $activite->id.'-'.$activite->categorieActivite->designation ?>"><?= $activite->designation ?></option>
            <?php endforeach ?>
        </select>
    </div>


<!--         <div class="form-group row">
            <label>Type ticket</label>
            <select id="typeticket" name="type_ticketId" class="form-control normal-rounded-input" id="select-input" onchange="">
              <option>...</option>
              <?php //foreach ($typetickets as $typeticket): ?>
                <option value="<?//= $typeticket->id.'-'.$typeticket->designation  ?>"><?//= $typeticket->designation ?></option>
            <?php //endforeach ?>
        </select>
    </div> -->

    <!-- <?= $form->field($model, 'type_ticketId')->textInput() ?> -->

    <div class="form-group row">
        <label>Valitité</label>
        <select id="validite" name="validiteId" class="form-control normal-rounded-input" id="select-input" onchange="showInput2()">
            <?php if (!$model->isNewRecord): ?>
              <option value="<?= $model->validite->id.'-'.$model->validite->designation ?>"><?= $model->validite ->designation ?></option>
          <?php else: ?>
              <option>...</option>
          <?php endif ?>
          <?php foreach ($validites as $validite): ?>
            <option value="<?= $validite->id.'-'.$validite->designation ?>"><?= trim($validite->designation) ?></option>
        <?php endforeach ?>
    </select>
</div>

<!-- <?= $form->field($model, 'validiteId')->textInput() ?> -->
<div class="form-group" style="margin-left: -15px;">

    <div id="periode"  class="" style="display: none; margin-left: -15px;">

        <div id=""  class="col-md-11" style="">
            <?= $form->field($model, 'periode')->textInput(['id'=>'temps','type'=>'range','value'=>'0','min'=>'0','max'=>'1440','step'=>'5','oninput'=>'flip_periode();']) ?>
        </div>        
        <div id=""  class="col-md-1" style="">
            <button id="t" name="Ticket[periode]" class="btn btn-primary" style="margin-top: 27px; margin-left: -15px;">0</button>
        </div>

    </div>

    <div id="nombre_validation"  class="" style="display: none; margin-left: -15px;">

        <div id=""  class="col-md-11" style="">
            <?= $form->field($model, 'nombre_validation')->textInput(['id'=>'nombre','type'=>'range','value'=>'1','min'=>'1','max'=>'100','step'=>'1','oninput'=>'flip_nombre();']) ?>
        </div>        
        <div id=""  class="col-md-1" style="">
            <button id="n" name="Ticket[nombre_validation]" class="btn btn-primary" style="margin-top: 27px; margin-left: -15px;">0</button>
        </div>

    </div>

    <div id="duree_validite"  class="" style="display: none; margin-left: -15px;">

        <div id=""  class="col-md-11" style="">
            <?= $form->field($model, 'duree_validite')->textInput(['id'=>'duree','type'=>'range','value'=>'0','min'=>'0','max'=>'180','step'=>'1','oninput'=>'flip_duree();']) ?>
        </div>        
        <div id=""  class="col-md-1" style="">
            <button id="r" name="Ticket[duree_validite]" class="btn btn-primary" style="margin-top: 27px; margin-left: -15px;">0</button>
        </div>

    </div>
    
</div>

<div class="form-group">
    <br>

    <?= Html::Button('Suivant <i class="fa fa-arrow-right"></i>', [ 'onclick' =>'suivant();','class' =>'btn btn-outline-primary col-md-5' ]) ?>
</div>

</div>

<div class="col-md-7" id="etape2" style="display: none;">

    <?= $form->field($model, 'designation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prix')->textInput() ?>

    <?= $form->field($model, 'nombre_ticket')->textInput(['maxlength' => true]) ?>

   <?php if (!$model->isNewRecord): ?>
    <img class="" src="<?php echo Yii::$app->homeUrl.'images/tickets/'.$model->image ?>" alt="Card image" style="height:200px; width:100%;" />
   <?php endif ?>
    <div class="custom-file" style="margin-top: 20px;">
       <!--  <input class="custom-file-input" type="file" id="file-input" name="imageFile" onchange="print_file();" /> -->

       <?= $form->field($model, 'imageFile')->fileInput(['id'=>'file-input', 'class'=>'custom-file-input', 'onchange'=>'print_file();']) ?>
       <label class="custom-file-label" for="file-input" id="logo">Charger une image...</label>
   </div>

   <div class="form-group">
    <br>
    <?= Html::Button('<i class="fa fa-arrow-left"></i> precedent', ['onclick' =>'precedent();','class' => 'btn btn-outline-primary col-md-5']) ?>
    <?= Html::submitButton($model->isNewRecord ? 'Valider' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-outline-success col-md-6' : 'btn btn-outline-primary']) ?>
</div>
</div>
<?php ActiveForm::end(); ?>
</div>

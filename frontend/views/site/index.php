<?php
use yii\helpers\Html;
use yii\widgets\ListView;
/* @var $this yii\web\View */
$this->title = 'e-Ticket | Marché universel de ticket';
?>
<script type="text/javascript">

  function ajouter(ticket){

    var input = {};
    input.ticket = ticket;
    input.nombre = $("#p_"+ticket).val();
    var url = "<?php echo Yii::$app->homeUrl ?>site/ajouter_panier";


    $.ajax({
      url: url,
      type: "POST",
      data: {
        input: input,
      },
      success: function (data) {
        if(data=='ok'){
          $("#r_"+ticket).show();
          $("#a_"+ticket).hide(5);

          var c = parseInt($('#count').text());
          var s = parseInt($('#subtotal').text());
          var p = parseInt($('#price_'+ticket).text());
          var n = parseInt($("#p_"+ticket).val());

          var v = c+n;
          var w = n*p+s;

          $('#count').text(v);
          $('#subtotal').text(w);

          if(n==0){
            $("#n_"+ticket).text(1);
          }else{
            $("#n_"+ticket).text(n);
          }

          $("#p_"+ticket).hide();
        }
        
      }
    });
  }

  function retirer(ticket){

    var input = {};
    input.ticket = ticket;
    var url = "<?php echo Yii::$app->homeUrl ?>site/retirer_panier";


    $.ajax({
      url: url,
      type: "POST",
      data: {
        input: input,
      },
      success: function (data) {
        if(data=='ok'){
          $("#a_"+ticket).show();
          $("#r_"+ticket).hide(5);
          $("#p_"+ticket).value==0;

          var c = parseInt($('#count').text());
          var s = parseInt($('#subtotal').text());
          var p = parseInt($('#price_'+ticket).text());
          var n = parseInt($("#p_"+ticket).val());

          var v = c-n;
          var w = s-n*p;

          if(v<0){$('#count').text(v);}
          else{$('#count').text(v);}

          if(w<0){$('#subtotal').text(w);}
          else{$('#subtotal').text(w);}

          


        }
        
      }
    });

  }

  function range_on(k){

    $("#p_"+k).show();
    $("#n_"+k).show();

  }


  function range_off(k){

    $("#p_"+k).hide();
    $("#n_"+k).show();
    var n = $("#p_"+k).val();
    var m = $("#n_"+k).val();
    // alert(n);
    if(n==1){
      $("#n_"+k).hide();
    }
    //alert(i);
  }

  function flip_panier(k){
    var i = $("#p_"+k).val();
    $("#n_"+k).text(i);
  }

</script>
<!-- Main Slider-->
<section class="hero-slider" style="background-image: url(<?php echo Yii::$app->homeUrl ?>img/hero-slider/main-bg.jpg);">
  <div class="owl-carousel large-controls dots-inside_" data-owl-carousel="{ &quot;nav&quot;: false, &quot;dots&quot;: true, &quot;loop&quot;: true, &quot;autoplay&quot;: true, &quot;autoplayTimeout&quot;: 7000 }">
    <div class="item">
      <div class="container padding-top-3x">
        <div class="row justify-content-center align-items-center">
          <div class="col-lg-5 col-md-6 padding-bottom-2x text-md-left text-center">
            <div class="from-bottom"><img class="d-inline-block w-300 mb-4" src="<?php echo Yii::$app->homeUrl ?>img/hero-slider/logo02.png" alt="Puma">
              <div class="h2 text-body text-normal mb-2 pt-1">Mobile ticket</div>
              <div class="h2 text-body text-normal mb-4 pb-1">Vote téléphone est votre <span class="text-bold">Ticket</span></div>
            </div><a class="btn btn-primary scale-up delay-1" href="shop-grid-ls.html">En savoir +</a>
          </div>
          <div class="col-md-6 padding-bottom-2x mb-3"><img class="d-block mx-auto" src="<?php echo Yii::$app->homeUrl ?>img/hero-slider/02.png" alt="Puma Backpack"></div>
        </div>
      </div>
    </div>
    <div class="item">
      <div class="container padding-top-3x">
        <div class="row justify-content-center align-items-center">
          <div class="col-lg-5 col-md-6 padding-bottom-2x text-md-left text-center">
            <div class="from-bottom"><img class="d-inline-block w-300 mb-4" src="<?php echo Yii::$app->homeUrl ?>img/hero-slider/logo01.png" alt="Converse">
              <div class="h2 text-body text-normal mb-2 pt-1">Un téléphone </div>
              <div class="h2 text-body text-normal mb-4 pb-1">plusieurs<span class="text-bold"> tickets</span></div>
            </div><a class="btn btn-primary scale-up delay-1" href="shop-single.html">En savoir +</a>
          </div>
          <div class="col-md-6 padding-bottom-2x mb-3"><img class="d-block mx-auto" src="<?php echo Yii::$app->homeUrl ?>img/hero-slider/01.png" alt="Chuck Taylor All Star II"></div>
        </div>
      </div>
    </div>
    <div class="item">
      <div class="container padding-top-3x">
        <div class="row justify-content-center align-items-center">
          <div class="col-lg-5 col-md-6 padding-bottom-2x text-md-left text-center">
            <div class="from-bottom"><img class="d-inline-block w-300 mb-4" src="<?php echo Yii::$app->homeUrl ?>img/hero-slider/logo03.png" style="width: 125px;" alt="Motorola">
              <div class="h2 text-body text-normal mb-2 pt-1">Votre téléphone devient</div>
              <div class="h2 text-body text-normal mb-4 pb-1">un marché de <span class="text-bold"> ticketing </span></div>
            </div><a class="btn btn-primary scale-up delay-1" href="shop-single.html">En savoir +</a>
          </div>
          <div class="col-md-6 padding-bottom-2x mb-3"><img class="d-block mx-auto" src="<?php echo Yii::$app->homeUrl ?>img/hero-slider/03.png" alt="Moto 360"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Top Categories-->
<section class="container padding-top-1x" style="padding: 20px 0px 20px 0px;">
  <!-- <h3 class="text-center mb-30">Top Categories</h3> -->
  <div class="row">
    <?= $this->render('evenement') ?>
    <div class="col-md-3 col-sm-6">
      <div class="card mb-30"><a class="card-img-tiles" href="shop-grid-ls.html">
        <div class="inner">
          <div class="main-img"><img src="<?php echo Yii::$app->homeUrl ?>img/shop/categories/01.png" alt="Category"></div>
          <div class="thumblist"><img  src="<?php echo Yii::$app->homeUrl ?>img/shop/categories/02.jpg" alt="Category"><img src="<?php echo Yii::$app->homeUrl ?>img/shop/categories/03.jpg" alt="Category"></div>
        </div></a>
        <div class="card-body text-center">
          <h4 class="card-title">Evènement</h4>
          <p class="text-muted">Tickets disponibles</p><a class="btn btn-outline-primary btn-sm" href="shop-grid-ls.html">Voir l'offre</a>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="card mb-30"><a class="card-img-tiles" href="shop-grid-ls.html">
        <div class="inner">
          <div class="main-img"><img src="<?php echo Yii::$app->homeUrl ?>img/shop/categories/04.png" alt="Category"></div>
          <div class="thumblist"><img src="<?php echo Yii::$app->homeUrl ?>img/shop/categories/05.jpg" alt="Category"><img src="<?php echo Yii::$app->homeUrl ?>img/shop/categories/06.jpg" alt="Category"></div>
        </div></a>
        <div class="card-body text-center">
          <h4 class="card-title">Transport</h4>
          <p class="text-muted">Tickets disponibles</p><a class="btn btn-outline-primary btn-sm" href="shop-grid-ls.html">Voir l'offre</a>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="card mb-30"><a class="card-img-tiles" href="shop-grid-ls.html">
        <div class="inner">
          <div class="main-img"><img src="<?php echo Yii::$app->homeUrl ?>img/shop/categories/07.png" alt="Category"></div>
          <div class="thumblist"><img src="<?php echo Yii::$app->homeUrl ?>img/shop/categories/08.jpg" alt="Category"><img src="<?php echo Yii::$app->homeUrl ?>img/shop/categories/09.jpg" alt="Category"></div>
        </div></a>
        <div class="card-body text-center">
          <h4 class="card-title">Parking</h4>
          <p class="text-muted">Tickets disponibles</p><a class="btn btn-outline-primary btn-sm" href="shop-grid-ls.html">Voir l'offre</a>
        </div>
      </div>
    </div>
  </div>

</section>
<!-- Promo #1-->

      <!-- Promo #2
      <section class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-xl-10 col-lg-12">
            <div class="fw-section rounded padding-top-4x padding-bottom-4x" style="background-image: url(<?php echo Yii::$app->homeUrl ?>img/banners/home02.jpg);"><span class="overlay rounded" style="opacity: .35;"></span>
              <div class="text-center">
                <h3 class="display-4 text-normal text-white text-shadow mb-1">Old Collection</h3>
                <h2 class="display-2 text-bold text-white text-shadow">HUGE SALE!</h2>
                <h4 class="d-inline-block h2 text-normal text-white text-shadow border-default border-left-0 border-right-0 mb-4">at our outlet stores</h4><br><a class="btn btn-primary margin-bottom-none" href="contacts.html">Locate Stores</a>
              </div>
            </div>
          </div>
        </div>
      </section>-->
      <!-- Featured Products Carousel-->
      <section class="padding-top padding-bottom-3x" style="padding-left: 10%; padding-right: 10%;">
        <!-- <h3 class="text-center mb-30">Les tickets</h3> -->
        <div class="alert-info alert fade in" style="font-size: 20px; text-align: center;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          Plateforme de ticketing
        </div>
        <div class="row">
          <?php
                       //$pjax =  Pjax::begin();
          $empty_message = '<div class="alert-danger alert fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>';


          echo ListView::widget([
            'dataProvider' => $dataProvider,
            'options' => [
              'class' => 'col-lg-12',
            ],
            'itemOptions' => ['class' => ''],
            'emptyText' => $empty_message,
            'summary' => false,
            'layout' => '{items}<div class="pagination-wrap">{pager}</div>',
            'itemView' => function ($model, $key, $index, $widget) {
              return $this->render('_ticket', [
                'model' => $model,
                'key' => $key,
              ]);
            },

          ]);
                        //Pjax::end();
          ?> 
        </div>

        <div class="text-center col-lg-12" id="r100" style=""><a class="btn btn-outline-success
          margin-top-3x" href="<?php echo Yii::$app->homeUrl ?>site/mon_panier"><i class="fa fa-shopping-cart"></i> Consulter le panier !</a><i class="fa fa-hand-down"></i></div>
       </section>
       <!-- Product Widgets-->
       <section class="container padding-bottom-2x">

       </section>

       <!-- Services-->
       <section class="padding-top-3x padding-bottom-3x bg-faded" >
        <div class="container">
          <div class="row">
            <div class="col-md-3 col-sm-6 text-center mb-30"><img class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3" src="<?php echo Yii::$app->homeUrl ?>img/services/01.png" alt="Shipping">
              <h6>Votre ticket vous suit</h6>
              <p class="text-muted margin-bottom-none">Où que vous soyez vous avez votre ticket</p>
            </div>
            <div class="col-md-3 col-sm-6 text-center mb-30"><img class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3" src="<?php echo Yii::$app->homeUrl ?>img/services/02.png" alt="Money Back">
              <h6>Un support unique pour vos ticket</h6>
              <p class="text-muted margin-bottom-none">Plus de souci à se faire votre mobile devient votre ticket</p>
            </div>
            <div class="col-md-3 col-sm-6 text-center mb-30"><img class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3" src="<?php echo Yii::$app->homeUrl ?>img/services/03.png" alt="Support">
              <h6>Votre passe disponible 24/7</h6>
              <p class="text-muted margin-bottom-none">Où que vous alliez vous avez votre passe!</p>
            </div>
            <div class="col-md-3 col-sm-6 text-center mb-30"><img class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3" src="<?php echo Yii::$app->homeUrl ?>img/services/04.png" alt="Payment">
              <h6>Les controles fiable et automatisés</h6>
              <p class="text-muted margin-bottom-none">Votre passe est unique et fiables!</p>
            </div>
          </div>
        </div>
      </section>
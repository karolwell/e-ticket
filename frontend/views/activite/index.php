<?php
use yii\helpers\Html;
use yii\widgets\ListView;
/* @var $this yii\web\View */
$this->title = 'e-Ticket | Marché universel de ticket';
?>


<section class="padding-top padding-bottom-x" style="padding-left: 10%; padding-right: 10%;">
  <!-- <h3 class="text-center mb-30">Les tickets</h3> -->
  <div class="alert-info alert fade in" style="font-size: 20px; text-align: center;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    Plateforme de ticketing
  </div>
  <div class="row">
    <?= $this->render('top_ticket') ?>

    <div class="col-lg-8 col-md-8" >
      <h6 class=" text-normal text-uppercase padding-top-1x mt-1">Les activités</h6>
      <hr class="margin-bottom-1x">
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
          return $this->render('_activite', [
            'model' => $model,
            'key' => $key,
            ]);
        },

        ]);
                        //Pjax::end();
        ?> 

        <div class="text-center col-lg-12 " id="r100" style="">
          <a class="btn btn-outline-primary margin-top-1x col-lg-5" href="<?php echo Yii::$app->homeUrl ?>site/tickets">
            <i class="fa fa-eye"></i> Voir tous les tickets
          </a>
          <a class="btn btn-outline-success margin-top-1x pull-right col-lg-5" href="<?php echo Yii::$app->homeUrl ?>site/mon_panier">
            <i class="fa fa-shopping-cart"></i> Consulter le panier !
          </a>
          <i class="fa fa-hand-down"></i>
        </div>
      </div>
    </div>

  </section>
  <!-- Product Widgets-->
  <section class="container padding-bottom-x">

  </section>


  <!-- Services-->
  <section class="padding-top-2x padding-bottom-1x bg-faded" >
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

  <!-- Top Categories
  <section class="container padding-top-2x bg-faded" style="padding: 20px 0px 20px 0px;">
    <div class="row">
      <?= $this->render('top_evenement') ?>
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

  </section>-->
  <!-- Promo #1-->
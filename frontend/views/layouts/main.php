<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>


<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8">
    <!-- SEO Meta Tags-->
    <meta name="description" content="e-Ticket - Universal ticket market">
    <meta name="keywords" content="shop, e-commerce, modern, flat style, responsive, online store, business, mobile, blog, bootstrap 4, html5, css3, jquery, js, gallery, slider, touch, creative, clean">
    <meta name="author" content="Well">
    <!-- Mobile Specific Meta Tag-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Favicon and Apple Icons-->
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="apple-touch-icon" href="touch-fa fa-iphone.png">
    <link rel="apple-touch-icon" sizes="152x152" href="touch-icon icon-ipad.png">
    <link rel="apple-touch-icon" sizes="180x180" href="touch-icon icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="167x167" href="touch-icon icon-ipad-retina.png">
    <!-- Vendor Styles including: Bootstrap, Font Icons, Plugins, etc.-->

    <!-- Customizer Styles-->
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
<!--     <link rel="stylesheet" media="screen" href="docs/feather-icons/feather-webfont/feather.css">
    <link rel="stylesheet" media="screen" href="docs/feather-icons/resources/style.css"> -->
    <!-- Google Tag Manager-->
    <script>
      (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
          new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-T4DJFPZ');

</script>
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
<!-- Modernizr-->
<script src=""></script>
</head> 
<?php $this->beginBody() ?>
<!-- Body-->
<body>
  <?= $this->render('_menu'); ?>
  <!-- Off-Canvas Wrapper-->
  <div class="">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <!-- Page Content-->
        <?= $content ?>
    </div>

    <!-- Popular Brands-->
    <section class="container padding-top-x padding-bottom-2x margin-top-x">
        <div class="">
         <!--  <h3 class="text-center mb-30 pb-2">Les éditeurs</h3> -->
          <div class="owl-carousel" data-owl-carousel="{ &quot;nav&quot;: false, &quot;dots&quot;: false, &quot;loop&quot;: true, &quot;autoplay&quot;: true, &quot;autoplayTimeout&quot;: 4000, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:2}, &quot;470&quot;:{&quot;items&quot;:3},&quot;630&quot;:{&quot;items&quot;:4},&quot;991&quot;:{&quot;items&quot;:5},&quot;1200&quot;:{&quot;items&quot;:6}} }"><img class="d-block w-110 opacity-75 m-auto" src="<?php echo Yii::$app->homeUrl ?>img/brands/01.png" alt="Adidas"><img class="d-block w-110 opacity-75 m-auto" src="<?php echo Yii::$app->homeUrl ?>img/brands/02.png" alt="Brooks"><img class="d-block w-110 opacity-75 m-auto" src="<?php echo Yii::$app->homeUrl ?>img/brands/03.png" alt="Valentino"><img class="d-block w-110 opacity-75 m-auto" src="<?php echo Yii::$app->homeUrl ?>img/brands/04.png" alt="Nike"><img class="d-block w-110 opacity-75 m-auto" src="<?php echo Yii::$app->homeUrl ?>img/brands/05.png" alt="Puma"><img class="d-block w-110 opacity-75 m-auto" src="<?php echo Yii::$app->homeUrl ?>img/brands/06.png" alt="New Balance"><img class="d-block w-110 opacity-75 m-auto" src="<?php echo Yii::$app->homeUrl ?>img/brands/07.png" alt="Dior"></div>
      </div>
  </section>

  <!-- Site Footer-->
  <footer class="site-footer">
    <div class="container">
      <div class="row">


        <div class="row">
            <div class="col-md-7 padding-bottom-1x">
              <!-- Payment Methods-->
              <div class="margin-bottom-1x" style="max-width: 615px;"><img src="<?php echo Yii::$app->homeUrl ?>img/payment_methods.png" alt="Payment Methods">
              </div>
          </div>
          <div class="col-md-5 padding-bottom-1x">
              <div class="margin-top-1x hidden-md-up"></div>
              <!--Subscription-->
              <form class="subscribe-form" action="../../../rokaux.us12.list-manage.com/subscribe/post.htm" method="post" target="_blank" novalidate>
                <div class="clearfix">
                  <div class=" input-light">
                    <input class="form-control col-md-10" style="background-color: transparent; color:#000;" type="email" name="EMAIL" placeholder="Votre e-mail">
                </div>
                <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                <div style="position: absolute; left: -5000px;" aria-hidden="true">
                    <input type="text" name="b_c7103e2c981361a6639545bd5_1194bb7544" tabindex="-1">
                </div>
                <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i></button>
            </div><span class="form-text text-sm text-white opacity-50">Incrivez vous, pour être à la une des nouveautés... Vous recevrez des notification par mail.
            </span>
        </form>
    </div>
</div>
<!-- Copyright
    <p class="footer-copyright">© All rights reserved. Made with &nbsp;<i class="fa fa-heart text-danger"></i><a href="../../../rokaux_default.html" target="_blank"> &nbsp;by rokaux</a></p>-->
</div>
</footer>
</div>
<!-- Back To Top Button--><a class="scroll-to-top-btn" href="index.html#"><i class="fa fa-arrow-up"></i></a>
<!-- Backdrop-->
<div class="site-backdrop"></div>
<!-- JavaScript (jQuery) libraries, plugins and custom scripts-->
<?php $this->endBody() ?>

<script type="text/javascript">
$(function() {
  var Accordion = function(el, multiple) {
    this.el = el || {};
    this.multiple = multiple || false;

    // Variables privadas
    var links = this.el.find('.link');
    // Evento
    links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
  }

  Accordion.prototype.dropdown = function(e) {
    var $el = e.data.el;
      $this = $(this),
      $next = $this.next();

    $next.slideToggle();
    $this.parent().toggleClass('open');

    if (!e.data.multiple) {
      $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
    };
  } 

  var accordion = new Accordion($('#accordion'), false);
});
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
<?php $this->endPage() ?>

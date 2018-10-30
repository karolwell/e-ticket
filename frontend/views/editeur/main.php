<?php
/* @var $this yii\web\View */
$this->title = 'e-Ticket | Espace editeur';
?>
    <!-- Off-Canvas Wrapper
      <div class="offcanvas-wrapper">-->
        <!-- Page Title-->
        <div class="page-title">
          <div class="container">
            <div class="column">
              <h1>Espace editeur</h1>
            </div>
<!--           <div class="column">
            <ul class="breadcrumbs">
              <li><a href="http://themes.rokaux.com/unishop/v2.2/template-1/components/index.html">Home</a>
              </li>
              <li class="separator">&nbsp;</li>
              <li><a href="accordion.html">Components</a>
              </li>
              <li class="separator">&nbsp;</li>
              <li>Modal</li>
            </ul>
          </div> -->
        </div>
      </div>
      <!-- Page Content-->
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-sm-1">
            <?= $this->render("menu") ?>
          </div>
          <div class="col-sm-9 col-md-9">
            <div class="">
              <?= isset($vue)?$this->render($vue):$this->render($vue="bord"); ?>
            </div>
          </div>
        </div>
      </div>
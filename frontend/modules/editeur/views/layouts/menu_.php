<ul id="accordion" class="accordion" style="position: static;">
  <li >
    <div class="link"><i class="fa fa-dashboard"></i><a style="color: #595959; text-decoration: none;" href="<?php echo Yii::$app->homeUrl ?>editeur/bord/index"> Tableau de bord <i class="fa fa-angle-right"></i></a></div>
<!--     <ul class="submenu">
      <li style="" ></li>
    </ul> -->
  </li>
  <li>
    <div class="link"><i class="fa fa-pencil"></i> Souscription <i class="fa fa-chevron-down"></i></div>
    <ul class="submenu">
      <li><a href="<?php echo Yii::$app->homeUrl ?>editeur/abonnement/index">Consulter</a></li>
      <li><a href="<?php echo Yii::$app->homeUrl ?>editeur/abonnement/create">Sourcrire</a></li>
    </ul>
  </li>
  <li>
    <div class="link"><i class="fa fa-clock-o"></i> Activité <i class="fa fa-chevron-down"></i></div>
    <ul class="submenu">
      <li><a href="<?php echo Yii::$app->homeUrl ?>editeur/activite/index">Liste</a></li>
      <li><a href="<?php echo Yii::$app->homeUrl ?>editeur/activite/create">Créer</a></li>
    </ul>
  </li>
  <li>
    <div class="link"><i class="fa fa-credit-card"></i> Ticket <i class="fa fa-chevron-down"></i></div>
    <ul class="submenu">
      <li><a href="<?php echo Yii::$app->homeUrl ?>editeur/ticket/index">Liste</a></li>
      <li><a href="<?php echo Yii::$app->homeUrl ?>editeur/ticket/create">Créer</a></li>
      <li><a href="<?php echo Yii::$app->homeUrl ?>editeur/ticket/create">Distribuer</a></li>
    </ul>
  </li>
  <li>
    <div class="link"><i class="fa fa-cog"></i> Configuration <i class="fa fa-chevron-down"></i></div>
    <ul class="submenu">
      <li><a href="#">Vérification de compte</a></li>
      <li><a href="#">Gestion des terminaux mobile</a></li>
      <li><a href="#">API/Echange de données</a></li>
    </ul>
  </li>
</ul> 
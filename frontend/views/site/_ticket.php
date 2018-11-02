<!-- Product-->
<?php if ($key<6): ?>
		<div class="product-card product-list margin-bottom-1x" onmouseleave="range_off(<?= $key ?>);">
			<a class="product-thumb" href="shop-items.html#" >
		<!-- <div class="rating-stars"><i class="icon-star filled"></i><i class="icon-star filled"></i><i class="icon-star filled"></i><i class="icon-star filled"></i><i class="icon-star filled"></i>
	</div> -->
	<?php if ($model['ticket']->image): ?>		
		<img style="width: 100%; height: 100px;" src="<?php echo Yii::$app->homeUrl ?>images/tickets/<?= $model['ticket']->image ?>	" alt="Product">
	<?php else: ?>
		<img style="width: 100%; height: 100px;"  src="<?php echo Yii::$app->homeUrl ?>img/shop/products/ticket.jpg" alt="Product">
	<?php endif ?>
	</a>
	<div class="product-info">
		<h3 class="product-title"><a href="shop-items.html#"><?= $model['categorie']->designation ?> - <?= $model['activite']->designation ?></a></h3>
		<h4 class="product-price"><span id="price_<?= $key ?>"><?= $model['ticket']->prix ?></span>  F CFA</h4>
		<p class="hidden-xs-down"><?= $model['activite']->description ?></p>
	</div>
	<div>
		<table class="table table-striped table-hover table-condensed">
			<tr><th>Disponible</th><td><?= $model['ticket']->nombre_ticket ?></td></tr>
			<tr><th>Du</th><td><?= $model['activite']->datedebut ?> </td></tr>
			<tr><th>Au</th><td><?= $model['activite']->datefin ?> </td></tr>
			<tr><th colspan="2" class="text-center "><i class="fa fa-2x fa-map-marker text-primary"></i>  <?= $model['activite']->lieu ?> </th></tr>
		</table>
	</div>
	<div class="product-buttons pull-left">
		<?php if ($model['disponible']=='ok'): ?>


			<button id="n_<?= $key ?>" class="btn btn-secondary btn btn-wishlist" style="color: #0da9ef; font-weight: bold; font-size: 13px; display: <?php if ($model['etat_panier']==0) echo 'none' ?>;" data-toggle="tooltip" title="Whishlist"> <?= $model['compte_panier'] ?></button>

			<input id="p_<?= $key ?>" style="display: none;" type="range" value="<?= $model['etat_panier']==1?  $model['compte_panier'] :  1 ?>" min="1" max="20" step="1" oninput="flip_panier(<?= $key ?>);" />

			<button id="r_<?= $key ?>" style="display: <?php if ($model['etat_panier']==0) echo 'none' ?>;" class="btn btn-outline-danger btn-sm" data-toast data-toast-type="danger" data-toast-position="topRight" data-toast-icon="fa fa-trash" data-toast-title="Ticket " data-toast-message=" retirer avec succès!" onclick="retirer(<?= $key ?>,<?= $model['etat_panier']==0?  1:  0 ?>);"><i class="fa fa-shopping-cart"></i> Retirer </button>


			<button onmouseover="range_on(<?= $key ?>,<?= $model['etat_panier']==0?  1:  0 ?>);" id="a_<?= $key ?>" style="display: <?php if ($model['etat_panier']==1) echo 'none' ?>;" class="btn btn-outline-primary btn-sm" data-toast data-toast-type="success" data-toast-position="topRight" data-toast-icon="fa fa-check" data-toast-title="Ticket " data-toast-message=" ajouter avec succès!" onclick="ajouter(<?= $key ?>,<?= $model['etat_panier']==1?  1:  0 ?>);">Ajouter <i class="fa fa-shopping-cart"></i></button>

		<?php else: ?>
			<button id="" class="btn btn-outline-secondary btn-sm" data-toast data-toast-type="secondary" data-toast-position="topRight" data-toast-icon="fa fa-lock" data-toast-title="Désolé " data-toast-message=" ticket indisponible!" > Indisponible <i class="fa fa-lock"></i></button>
		<?php endif ?>
	</div>
	</div>
<?php endif ?>

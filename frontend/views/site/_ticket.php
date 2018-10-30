<!-- Product-->
<div class=" grid-item col-md-3 col-md-3 margin-top-1x "  onmouseleave="range_off(<?= $key ?>);">
	<div class="product-card">
		<div class="product-badge text-danger"><h3 class="product-title"><a href="shop-single.html"> <?= $model['categorie']->designation ?></a></h3></div> 
		<div class="text-danger" style="float: right;"><h2 class="product-price text-primary"> <span id="price_<?= $key ?>"><?= $model['ticket']->prix ?></span>  F CFA</h2></div>
		<center class="text-danger col-md-12" style=""><a style="text-decoration: none;" href=""><h2 class="product-price text-success">  <?= $model['activite']->designation ?></h2></a></center>
		<a class="product-thumb" href="shop-single.html">
			<?php if ($model['ticket']->image): ?>		
				<img style="width: 100%; height: 200px;" src="<?php echo Yii::$app->homeUrl ?>images/tickets/<?= $model['ticket']->image ?>	" alt="Product">
				<?php else: ?>
					<img style="width: 100%; height: 200px;"  src="<?php echo Yii::$app->homeUrl ?>img/shop/products/ticket.jpg" alt="Product">
				<?php endif ?>
			</a>

			<div class="product-buttons">
				<?php if ($model['disponible']=='ok'): ?>
					

					<input id="p_<?= $key ?>" style="display: none;" type="range" value="<?= $model['etat_panier']==1?  $model['compte_panier'] :  1 ?>" min="1" max="20" step="1" oninput="flip_panier(<?= $key ?>);" />

					<button id="r_<?= $key ?>" style="display: <?php if ($model['etat_panier']==0) echo 'none' ?>;" class="btn btn-outline-danger btn-sm" data-toast data-toast-type="danger" data-toast-position="topRight" data-toast-icon="fa fa-trash" data-toast-title="Ticket " data-toast-message=" retirer avec succès!" onclick="retirer(<?= $key ?>,<?= $model['etat_panier']==0?  1:  0 ?>);"><i class="fa fa-shopping-cart"></i> Retirer </button>

					<button id="n_<?= $key ?>" class="btn btn-secondary btn-sm btn-wishlist" style="color: #0da9ef; font-weight: bold; font-size: 13px; display: <?php if ($model['etat_panier']==0) echo 'none' ?>;" data-toggle="tooltip" title="Whishlist"> <?= $model['compte_panier'] ?></button>


					<button onmouseover="range_on(<?= $key ?>,<?= $model['etat_panier']==0?  1:  0 ?>);" id="a_<?= $key ?>" style="display: <?php if ($model['etat_panier']==1) echo 'none' ?>;" class="btn btn-outline-primary btn-sm" data-toast data-toast-type="success" data-toast-position="topRight" data-toast-icon="fa fa-check" data-toast-title="Ticket " data-toast-message=" ajouter avec succès!" onclick="ajouter(<?= $key ?>,<?= $model['etat_panier']==1?  1:  0 ?>);">Ajouter <i class="fa fa-shopping-cart"></i></button>

					<?php else: ?>
						<button id="" class="btn btn-outline-secondary btn-sm" data-toast data-toast-type="secondary" data-toast-position="topRight" data-toast-icon="fa fa-lock" data-toast-title="Désolé " data-toast-message=" ticket indisponible!" > Indisponible <i class="fa fa-lock"></i></button>
					<?php endif ?>
				</div>

			</div>
		</div>
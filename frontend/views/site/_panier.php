<div style="<?php if($nombre>3) echo 'overflow-y: scroll; height: 250px;' ?>" >
	
	<?php foreach ($tickets as $ticket): ?>

		<?php if ($ticket['etat_panier']==1): ?>

			<div class="dropdown-product-item">
				<span class="dropdown-product-remove"><i class="fa fa-time"></i></span>
				<a class="dropdown-product-thumb" href="shop-single.html">
				<?php if ($ticket['ticket']->image!=null): ?>
					<img src="<?php echo Yii::$app->homeUrl ?>images/tickets/<?= $ticket['ticket']->image ?>" alt="Product">
				<?php else: ?>
					<img src="<?php echo Yii::$app->homeUrl ?>img/cart-dropdown/ticket.jpg" alt="Product">
				<?php endif ?>
			</a>
				<div class="dropdown-product-info"><a class="dropdown-product-title" href="shop-single.html"> Ticket <?= $ticket['activite']->designation ?> </a><span class="dropdown-product-details"><?= $ticket['compte_panier'] ?> x <?= $ticket['ticket']->prix ?> FCFA </span></div>
			</div>

		<?php endif ?>

	<?php endforeach ?>  

</div>


<div class="toolbar-dropdown-group">
	<div class="column"></div>
	<div class="column text-center"><span class="text-lg">Total: </span> <strong class="text-lg text-large"> <?= $total ?>&nbsp; CFA</strong></div>
</div>
<div class="toolbar-dropdown-group">
	<div class="column"><a class="btn btn-sm btn-block btn-secondary" href="cart.html">Abandonner</a></div>
	<div class="column"><a class="btn btn-sm btn-block btn-success" href="<?php echo Yii::$app->homeUrl ?>site/mon_panier">Continuer</a></div>
</div>
      <!-- Page Content-->
      <div class="container padding-bottom-3x mb-1">
        <!-- Alert-->
        <div class="alert alert-info alert-dismissible fade show text-center" style="margin-bottom: 30px;">
         <i class="fa fa fa-shopping-cart"></i> &nbsp;&nbsp; composion du <strong> panier </strong> .</div>
         <!-- Shopping Cart-->
         <div class="table-responsive shopping-cart">
          <table class="table">
            <thead>
              <tr>
                <th>Produits </th>
                <th class="text-center">Quantité</th>
                <th class="text-center">Prix unique (CFA)</th>
                <th class="text-center">Total (CFA)</th>
                <th class="text-center"><a class="btn btn-sm btn-outline-danger" href="cart.html#"><i class="fa fa-trash"></i> Vider</a></th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($tickets as $key => $ticket): ?>
                <?php if ($ticket['etat_panier']==1): ?>
                <tr>
                  <td>
                    <div class="product-item">
                      <a class="product-thumb" href="shop-single.html">
                        <?php if ($ticket['ticket']->image!=null): ?>
                          <img src="<?php echo Yii::$app->homeUrl ?>images/tickets/<?= $ticket['ticket']->image ?>" alt="Product">
                          <?php else: ?>
                            <img src="<?php echo Yii::$app->homeUrl ?>img/cart-dropdown/ticket.jpg" alt="Product">
                          <?php endif ?>
                        </a>
                        <div class="product-info">
                          <h4 class="product-title"><a href="shop-single.html">Ticket</a></h4><span> Ticket <?= $ticket['activite']->designation ?> </span>
                        </div>
                      </div>
                    </td>
                    <td class="text-center">
                      
                      <input id="p_<?= $key ?>" style="display:none ; width: 39%; margin-top:40px;" type="range" value="<?= $ticket['etat_panier']==1?  $ticket['compte_panier'] :  1 ?>" min="1" max="20" step="1" oninput="flip_modifpanier(<?= $key.','.$ticket['compte_panier'].','.$tot_nombre.','.$total ?>);" onchange="modif_panier(<?= $key ?>);" onmouseleave="show_edit(<?= $key ?>);" /><a href="#" onmouseover="show_range(<?= $key ?>);" id="e_<?= $key ?>"><i style="color: #0da9ef; font-weight: bold; font-size: 20px;" class="fa fa-pencil"></i></a> 
                      <button id="n_<?= $key ?>" class="btn btn-secondary btn-sm btn-wishlist" style="color: #0da9ef; font-weight: bold; font-size: 13px; display: <?php if ($ticket['etat_panier']==0) echo 'none' ?>; top:-20px;" data-toggle="tooltip" title="Whishlist"> <?= $ticket['compte_panier'] ?></button>
                    </td>
                    <td class="text-center text-lg text-medium" id="u_<?= $key ?>" ><?= $ticket['ticket']->prix ?></td>
                    <td class="text-center text-lg text-medium" id="t_<?= $key ?>"><?= $ticket['compte_panier']*$ticket['ticket']->prix ?> </td>
                    <td class="text-center"><a class="remove-from-cart" href="cart.html#" data-toggle="tooltip" title="Remove item"><i class="fa fa-times"></i></a></td>
                  </tr>
                  <?php endif ?>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
          <div class="shopping-cart-footer">
          <div class="column">
            <form class="coupon-form" method="post">
              <input class="form-control form-control-sm" type="text" placeholder="Entrer votre numero de telephone ..." required>
              <!-- <button class="btn btn-outline-primary btn-sm" type="submit">Apply Coupon</button> -->
            </form>
          </div>
          <div class="column text-lg" style="font-weight: bold;">Ticket(s): <span class="text-medium" id="n_ticket"><?= $tot_nombre ?> </span>&nbsp;&nbsp;&nbsp;  Total: <span class="text-medium" id="total"><?= $total ?> </span>F CFA</div>
        </div>
        <div class="shopping-cart-footer">
          <div class="column"><a class="btn btn-outline-secondary" href="<?php echo Yii::$app->homeUrl ?>site/index"><i class="fa fa-arrow-left"></i>&nbsp;Retour</a></div>
          <div class="column"><a class="btn btn-outline-primary" href="cart.html#" data-toast data-toast-type="success" data-toast-position="topRight" data-toast-icon="icon-circle-check" data-toast-title="Your cart" data-toast-message="is updated successfully!">rafraichir</a><a class="btn btn-outline-success" href="checkout-address.html">Continuer</a></div>
        </div>

      </div>
<?php
use frontend\models\TypeUser; 
?>
<div class="offcanvas-container" id="mobile-menu"><a class="account-link" href="account-orders.html">
    <div class="user-ava"><img src="img/account/user-ava-md.jpg" alt="Daniel Adams">
    </div>
    <div class="user-info">
      <h6 class="user-name">Daniel Adams</h6><span class="text-sm text-white opacity-60">290 Reward points</span>
    </div></a>
    <nav class="offcanvas-menu">
      <ul class="menu">
        <li class="has-children active"><span><a href="index.html"><span>Home</span></a><span class="sub-menu-toggle"></span></span>
          <ul class="offcanvas-submenu">
            <li class="active"><a href="index.html">Featured Products Slider</a></li>
            <li><a href="home-featured-categories.html">Featured Categories</a></li>
            <li><a href="home-collection-showcase.html">Products Collection Showcase</a></li>
          </ul>
        </li>
        <li class="has-children"><span><a href="shop-grid-ls.html"><span>Shop</span></a><span class="sub-menu-toggle"></span></span>
          <ul class="offcanvas-submenu">
            <li><a href="shop-categories.html">Shop Categories</a></li>
            <li class="has-children"><span><a href="shop-grid-ls.html"><span>Shop Grid</span></a><span class="sub-menu-toggle"></span></span>
              <ul class="offcanvas-submenu">
                <li><a href="shop-grid-ls.html">Grid Left Sidebar</a></li>
                <li><a href="shop-grid-rs.html">Grid Right Sidebar</a></li>
                <li><a href="shop-grid-ns.html">Grid No Sidebar</a></li>
              </ul>
            </li>
            <li class="has-children"><span><a href="shop-list-ls.html"><span>Shop List</span></a><span class="sub-menu-toggle"></span></span>
              <ul class="offcanvas-submenu">
                <li><a href="shop-list-ls.html">List Left Sidebar</a></li>
                <li><a href="shop-list-rs.html">List Right Sidebar</a></li>
                <li><a href="shop-list-ns.html">List No Sidebar</a></li>
              </ul>
            </li>
            <li><a href="shop-single.html">Single Product</a></li>
            <li><a href="cart.html">Cart</a></li>
            <li><a href="checkout.html">Checkout</a></li>
          </ul>
        </li>
        <li class="has-children"><span><a href="#">Categories</a><span class="sub-menu-toggle"></span></span>
          <ul class="offcanvas-submenu">
            <li class="has-children"><span><a href="#">Men's Shoes</a><span class="sub-menu-toggle"></span></span>
              <ul class="offcanvas-submenu">
                <li><a href="#">Sneakers</a></li>
                <li><a href="#">Loafers</a></li>
                <li><a href="#">Boat Shoes</a></li>
                <li><a href="#">Sandals</a></li>
                <li><a href="#">View All</a></li>
              </ul>
            </li>
            <li class="has-children"><span><a href="#">Women's Shoes</a><span class="sub-menu-toggle"></span></span>
              <ul class="offcanvas-submenu">
                <li><a href="#">Sandals</a></li>
                <li><a href="#">Flats</a></li>
                <li><a href="#">Sneakers</a></li>
                <li><a href="#">Heels</a></li>
                <li><a href="#">View All</a></li>
              </ul>
            </li>
            <li class="has-children"><span><a href="#">Men's Clothing</a><span class="sub-menu-toggle"></span></span>
              <ul class="offcanvas-submenu">
                <li><a href="#">Shirts &amp; Tops</a></li>
                <li><a href="#">Pants</a></li>
                <li><a href="#">Jackets</a></li>
                <li><a href="#">View All</a></li>
              </ul>
            </li>
            <li class="has-children"><span><a href="#">Women's Clothing</a><span class="sub-menu-toggle"></span></span>
              <ul class="offcanvas-submenu">
                <li><a href="#">Dresses</a></li>
                <li><a href="#">Shirts &amp; Tops</a></li>
                <li><a href="#">Shorts</a></li>
                <li><a href="#">Swimwear</a></li>
                <li><a href="#">View All</a></li>
              </ul>
            </li>
            <li class="has-children"><span><a href="#">Bags</a><span class="sub-menu-toggle"></span></span>
              <ul class="offcanvas-submenu">
                <li><a href="#">Handbags</a></li>
                <li><a href="#">Backpacks</a></li>
                <li><a href="#">Luggage</a></li>
                <li><a href="#">Wallets</a></li>
                <li><a href="#">View All</a></li>
              </ul>
            </li>
            <li class="has-children"><span><a href="#">Accessories</a><span class="sub-menu-toggle"></span></span>
              <ul class="offcanvas-submenu">
                <li><a href="#">Sunglasses</a></li>
                <li><a href="#">Hats</a></li>
                <li><a href="#">Watches</a></li>
                <li><a href="#">Jewelry</a></li>
                <li><a href="#">Belts</a></li>
                <li><a href="#">View All</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="has-children"><span><a href="account-orders.html"><span>Account</span></a><span class="sub-menu-toggle"></span></span>
          <ul class="offcanvas-submenu">
            <li><a href="account-login.html">Login / Register</a></li>
            <li><a href="account-password-recovery.html">Password Recovery</a></li>
            <li><a href="account-orders.html">Orders List</a></li>
            <li><a href="account-wishlist.html">Wishlist</a></li>
            <li><a href="account-profile.html">Profile Page</a></li>
            <li><a href="account-address.html">Contact / Shipping Address</a></li>
            <li><a href="account-open-ticket.html">Open Ticket</a></li>
            <li><a href="account-tickets.html">My Tickets</a></li>
            <li><a href="account-single-ticket.html">Single Ticket</a></li>
          </ul>
        </li>
        <li class="has-children"><span><a href="blog-rs.html"><span>Blog</span></a><span class="sub-menu-toggle"></span></span>
          <ul class="offcanvas-submenu">
            <li class="has-children"><span><a href="blog-rs.html"><span>Blog Layout</span></a><span class="sub-menu-toggle"></span></span>
              <ul class="offcanvas-submenu">
                <li><a href="blog-rs.html">Blog Right Sidebar</a></li>
                <li><a href="blog-ls.html">Blog Left Sidebar</a></li>
                <li><a href="blog-ns.html">Blog No Sidebar</a></li>
              </ul>
            </li>
            <li class="has-children"><span><a href="blog-single-rs.html"><span>Single Post Layout</span></a><span class="sub-menu-toggle"></span></span>
              <ul class="offcanvas-submenu">
                <li><a href="blog-single-rs.html">Post Right Sidebar</a></li>
                <li><a href="blog-single-ls.html">Post Left Sidebar</a></li>
                <li><a href="blog-single-ns.html">Post No Sidebar</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="has-children"><span><a href="#"><span>Pages</span></a><span class="sub-menu-toggle"></span></span>
          <ul class="offcanvas-submenu">
            <li><a href="about.html">About Us</a></li>
            <li><a href="mobile-app.html">Unishop Mobile App</a></li>
            <li><a href="services.html">Services</a></li>
            <li><a href="contacts.html">Contacts</a></li>
            <li><a href="faq.html">Help / FAQ</a></li>
            <li><a href="order-tracking.html">Order Tracking</a></li>
            <li><a href="search-results.html">Search Results</a></li>
            <li><a href="404.html">404</a></li>
            <li><a href="coming-soon.html">Coming Soon</a></li>
            <li><a class="text-danger" href="docs/dev-setup.html">Documentation</a></li>
          </ul>
        </li>
        <li class="has-children"><span><a href="components/accordion.html"><span>Components</span></a><span class="sub-menu-toggle"></span></span>
          <ul class="offcanvas-submenu">
            <li><a href="components/accordion.html">Accordion</a></li>
            <li><a href="components/alerts.html">Alerts</a></li>
            <li><a href="components/buttons.html">Buttons</a></li>
            <li><a href="components/cards.html">Cards</a></li>
            <li><a href="components/carousel.html">Carousel</a></li>
            <li><a href="components/countdown.html">Countdown</a></li>
            <li><a href="components/forms.html">Forms</a></li>
            <li><a href="components/gallery.html">Gallery</a></li>
            <li><a href="components/google-maps.html">Google Maps</a></li>
            <li><a href="components/images.html">Images &amp; Figures</a></li>
            <li><a href="components/list-group.html">List Group</a></li>
            <li><a href="components/market-social-buttons.html">Market &amp; Social Buttons</a></li>
            <li><a href="components/media.html">Media Object</a></li>
            <li><a href="components/modal.html">Modal</a></li>
            <li><a href="components/pagination.html">Pagination</a></li>
            <li><a href="components/pills.html">Pills</a></li>
            <li><a href="components/progress-bars.html">Progress Bars</a></li>
            <li><a href="components/shop-items.html">Shop Items</a></li>
            <li><a href="components/steps.html">Steps</a></li>
            <li><a href="components/tables.html">Tables</a></li>
            <li><a href="components/tabs.html">Tabs</a></li>
            <li><a href="components/team.html">Team</a></li>
            <li><a href="components/toasts.html">Toast Notifications</a></li>
            <li><a href="components/tooltips-popovers.html">Tooltips &amp; Popovers</a></li>
            <li><a href="components/typography.html">Typography</a></li>
            <li><a href="components/video-player.html">Video Player</a></li>
            <li><a href="components/widgets.html">Widgets</a></li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
  <!-- Topbar-->
  <div class="topbar" style="display: none;">
  </div>
  <!-- Navbar-->
  <!-- Remove "navbar-sticky" class to make navigation bar scrollable with the page.-->
  <header class="navbar navbar-sticky">
    <!-- Search-->
    <form class="site-search" method="get">
      <input type="text" name="site_search" placeholder="Type to search...">
      <div class="search-tools"><span class="clear-search"></span><span class="close-search"><i class="fa fa-times"></i></span></div>
    </form>
    <div class="site-branding">
      <div class="inner">
        <!-- Off-Canvas Toggle (#shop-categories)<a class="offcanvas-toggle cats-toggle text-center" href="index.html#shop-categories" data-toggle="offcanvas"><i class=" fa fa-align-justify "></i></a>-->
        <!-- Off-Canvas Toggle (#mobile-menu)<a class="offcanvas-toggle menu-toggle" href="index.html#mobile-menu" data-toggle="offcanvas"><i class=" fa fa-align-justify "></i></a>-->
        <!-- Site Logo--><a class="site-logo" href="<?php echo Yii::$app->homeUrl ?>site/index"><img src="<?php echo Yii::$app->homeUrl ?>img/logo/logo.png" alt="" style="height: 100px; margin-top:-25px; "></a>
      </div>
    </div>
    <!-- Main Navigation-->
    <nav class="site-menu">
      <ul>
        <li class="has-megamenu active"><a href="<?php echo Yii::$app->homeUrl ?>site/index"><span><i class=" fa  fa-home"></i> Accueil</span></a>
<!--         <ul class="mega-menu">
          <li><a class="d-block img-thumbnail text-center navi-link" href="index.html"><img alt="Featured Products Slider" src="<?php echo Yii::$app->homeUrl ?>img/mega-menu-home/01.jpg">
              <h6 class="mt-3">Featured Products Slider</h6></a></li>
              <li><a class="d-block img-thumbnail text-center navi-link" href="home-featured-categories.html"><img alt="Featured Categories" src="<?php echo Yii::$app->homeUrl ?>img/mega-menu-home/02.jpg">
                  <h6 class="mt-3">Featured Categories</h6></a></li>
                  <li><a class="d-block img-thumbnail text-center navi-link" href="home-collection-showcase.html"><img alt="Products Collection Showcase" src="<?php echo Yii::$app->homeUrl ?>img/mega-menu-home/03.jpg">
                      <h6 class="mt-3">Products Collection Showcase</h6></a></li>
                      <li>
                        <div class="img-thumbnail text-center"><img alt="More To Come. Stay Tuned!" src="<?php echo Yii::$app->homeUrl ?>img/mega-menu-home/04.jpg">
                          <h6 class="mt-3">More To Come. Stay Tuned!</h6>
                      </div>
                  </li>
                </ul> -->
              </li>
              <li class="has-megamenu "><a href="<?php echo Yii::$app->homeUrl ?>impression/imprimer/index"><span><i class=" fa  fa-print"></i> Imprimer</span></a></li>
<!--              <li><a href="<?php echo Yii::$app->homeUrl ?>site/signup"><span><i class=" fa fa-2x fa-pencil"></i>  Editeur</span></a>
             <ul class="sub-menu">
                <li><a href="shop-categories.html">Shop Categories</a></li>
                <li class="has-children"><a href="shop-grid-ls.html"><span>Shop Grid</span></a>
                    <ul class="sub-menu">
                        <li><a href="shop-grid-ls.html">Grid Left Sidebar</a></li>
                        <li><a href="shop-grid-rs.html">Grid Right Sidebar</a></li>
                        <li><a href="shop-grid-ns.html">Grid No Sidebar</a></li>
                    </ul>
                </li>
                <li class="has-children"><a href="shop-list-ls.html"><span>Shop List</span></a>
                    <ul class="sub-menu">
                        <li><a href="shop-list-ls.html">List Left Sidebar</a></li>
                        <li><a href="shop-list-rs.html">List Right Sidebar</a></li>
                        <li><a href="shop-list-ns.html">List No Sidebar</a></li>
                    </ul>
                </li>
                <li><a href="shop-single.html">Single Product</a></li>
                <li><a href="cart.html">Cart</a></li>
                <li class="has-children"><a href="checkout-address.html"><span>Checkout</span></a>
                    <ul class="sub-menu">             
                        <li><a href="checkout-address.html">Address</a></li>
                        <li><a href="checkout-shipping.html">Shipping</a></li>
                        <li><a href="checkout-payment.html">Payment</a></li>
                        <li><a href="checkout-review.html">Review</a></li>
                        <li><a href="checkout-complete.html">Complete</a></li>
                    </ul>
                </li>
              </ul>
            </li> -->

            <li><a href="account-orders.html"><span><i class=" fa fa-calendar"></i>  Evenement</span></a>
<!--             <ul class="sub-menu">
                <li><a href="account-login.html">Login / Register</a></li>
                <li><a href="account-password-recovery.html">Password Recovery</a></li>
                <li><a href="account-orders.html">Orders List</a></li>
                <li><a href="account-wishlist.html">Wishlist</a></li>
                <li><a href="account-profile.html">Profile Page</a></li>
                <li><a href="account-address.html">Contact / Shipping Address</a></li>
                <li><a href="account-tickets.html">My Tickets</a></li>
                <li><a href="account-single-ticket.html">Single Ticket</a></li>
              </ul> -->
            </li>
            <li class="has-megamenu"><a href="<?php echo Yii::$app->homeUrl ?>site/contact"><span><i class=" fa  fa-ticket"></i>  Ticket</span></a>
<!--               <ul class="mega-menu">
                <li><span class="mega-menu-title">A - F</span>
                  <ul class="sub-menu">
                    <li><a href="components/accordion.html">Accordion</a></li>
                    <li><a href="components/alerts.html">Alerts</a></li>
                    <li><a href="components/buttons.html">Buttons</a></li>
                    <li><a href="components/cards.html">Cards</a></li>
                    <li><a href="components/carousel.html">Carousel</a></li>
                    <li><a href="components/countdown.html">Countdown</a></li>
                    <li><a href="components/forms.html">Forms</a></li>
                  </ul>
                </li>
                <li><span class="mega-menu-title">G - M</span>
                  <ul class="sub-menu">
                    <li><a href="components/gallery.html">Gallery</a></li>
                    <li><a href="components/google-maps.html">Google Maps</a></li>
                    <li><a href="components/images.html">Images &amp; Figures</a></li>
                    <li><a href="components/list-group.html">List Group</a></li>
                    <li><a href="components/market-social-buttons.html">Market &amp; Social Buttons</a></li>
                    <li><a href="components/media.html">Media Object</a></li>
                    <li><a href="components/modal.html">Modal</a></li>
                  </ul>
                </li>
                <li><span class="mega-menu-title">P - T</span>
                  <ul class="sub-menu">
                    <li><a href="components/pagination.html">Pagination</a></li>
                    <li><a href="components/pills.html">Pills</a></li>
                    <li><a href="components/progress-bars.html">Progress Bars</a></li>
                    <li><a href="components/shop-items.html">Shop Items</a></li>
                    <li><a href="components/steps.html">Steps</a></li>
                    <li><a href="components/tables.html">Tables</a></li>
                    <li><a href="components/tabs.html">Tabs</a></li>
                  </ul>
                </li>
                <li><span class="mega-menu-title">T - W</span>
                  <ul class="sub-menu">
                    <li><a href="components/team.html">Team</a></li>
                    <li><a href="components/toasts.html">Toast Notifications</a></li>
                    <li><a href="components/tooltips-popovers.html">Tooltips &amp; Popovers</a></li>
                    <li><a href="components/typography.html">Typography</a></li>
                    <li><a href="components/video-player.html">Video Player</a></li>
                    <li><a href="components/widgets.html">Widgets</a></li>
                  </ul>
                </li>
              </ul> -->
            </li>
            <li><a href="blog-rs.html"><span> <i class=" fa fa-phone"></i>  Contact</span></a>
<!--               <ul class="sub-menu">
                <li class="has-children"><a href="blog-rs.html"><span>Blog Layout</span></a>
                  <ul class="sub-menu">
                    <li><a href="blog-rs.html">Blog Right Sidebar</a></li>
                    <li><a href="blog-ls.html">Blog Left Sidebar</a></li>
                    <li><a href="blog-ns.html">Blog No Sidebar</a></li>
                  </ul>
                </li>
                <li class="has-children"><a href="blog-single-rs.html"><span>Single Post Layout</span></a>
                  <ul class="sub-menu">
                    <li><a href="blog-single-rs.html">Post Right Sidebar</a></li>
                    <li><a href="blog-single-ls.html">Post Left Sidebar</a></li>
                    <li><a href="blog-single-ns.html">Post No Sidebar</a></li>
                  </ul>
                </li>
              </ul>
            </li>
          </ul> -->
        </nav>
        <!-- Toolbar-->
        <div class="toolbar">
          <div class="inner">
            <div class="tools">
              <div class="search"><i class="fa fa-search"></i></div>

              <?php if(Yii::$app->user->isGuest): ?>
                <div class="account"><a href="#"></a><i class="fa fa-cog"></i>
                  <div class="toolbar-dropdown">
                    <div class="dropdown-product-item">
                      <div class="dropdown-product-info text-center"><a class="dropdown-product-title" style="font-size: 20px;"  href="<?php echo Yii::$app->homeUrl ?>site/login"><i class="fa fa-lock"></i> Connexion</a></div>
                    </div>
                    <div class="dropdown-product-item">
                      <div class="dropdown-product-info text-center"><a class="dropdown-product-title" style="font-size: 20px;"  href="<?php echo Yii::$app->homeUrl ?>site/signup"><i class="fa fa-pencil"></i> Inscription</a></div>
                    </div>
                  </div>
                </div>
              <?php else: ?>
                <div class="account"><a href="#"></a><i class="fa fa-user"></i>
                  <ul class="toolbar-dropdown">
                    <li class="sub-menu-user">
                      <div class="user-ava"><img src="<?php echo Yii::$app->homeUrl ?>images/editeurs/<?= Yii::$app->user->identity->logo ?>" alt="<?= Yii::$app->user->identity->username ?>">
                      </div>
                      <div class="user-info">
                        <h6 class="user-name"><?= Yii::$app->user->identity->username ?></h6><span class="text-xs text-muted"><?= TypeUser::findOne(Yii::$app->user->identity->type_userId )->designation ?></span>
                      </div>
                    </li>
                    
                    <li class="sub-menu-separator"></li>
                    <li><a href="<?php echo Yii::$app->homeUrl ?>editeur/bord/index" > <i class="fa fa-home"></i>Mon espace</a></li>

                    <li class="sub-menu-separator"></li>
                    <li><a href="<?php echo Yii::$app->homeUrl ?>site/logout"> <i class="fa fa-unlock"></i>Deconnexion</a></li>
                  </ul>
                </div>
              <?php endif ?>

              <div class="cart"><a href="#"></a><i class="fa fa-shopping-cart"></i><span class="count">3</span><span class="subtotal">13 000 F CFA</span>
                <div class="toolbar-dropdown">
                  <div class="dropdown-product-item"><span class="dropdown-product-remove"><i class="fa fa-cross"></i></span><a class="dropdown-product-thumb" href="shop-single.html"><img src="<?php echo Yii::$app->homeUrl ?>img/cart-dropdown/ticket.jpg" alt="Product"></a>
                    <div class="dropdown-product-info"><a class="dropdown-product-title" href="shop-single.html">Ticket concert </a><span class="dropdown-product-details">1 x FCFA 10000</span></div>
                  </div>
                  <div class="dropdown-product-item"><span class="dropdown-product-remove"><i class="fa fa-cross"></i></span><a class="dropdown-product-thumb" href="shop-single.html"><img src="<?php echo Yii::$app->homeUrl ?>img/cart-dropdown/ticket.jpg" alt="Product"></a>
                    <div class="dropdown-product-info"><a class="dropdown-product-title" href="shop-single.html">Ticket concert</a><span class="dropdown-product-details">2 x FCFA 2000</span></div>
                  </div>
                  <div class="dropdown-product-item"><span class="dropdown-product-remove"><i class="fa fa-cross"></i></span><a class="dropdown-product-thumb" href="shop-single.html"><img src="<?php echo Yii::$app->homeUrl ?>img/cart-dropdown/ticket.jpg" alt="Product"></a>
                    <div class="dropdown-product-info"><a class="dropdown-product-title" href="shop-single.html">Ticket concert</a><span class="dropdown-product-details">1 x FCFA 1000</span></div>
                  </div>
                  <div class="toolbar-dropdown-group">
                    <div class="column"><span class="text-lg">Total:</span></div>
                    <div class="column text-right"><span class="text-lg text-medium">CFA 13 000&nbsp;</span></div>
                  </div>
                  <div class="toolbar-dropdown-group">
                    <div class="column"><a class="btn btn-sm btn-block btn-secondary" href="cart.html">View Cart</a></div>
                    <div class="column"><a class="btn btn-sm btn-block btn-success" href="checkout-address.html">Checkout</a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>
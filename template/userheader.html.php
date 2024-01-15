<header class="site-navbar" role="banner">
  <div class="site-navbar-top">
    <div class="container">
      <div class="row align-items-center">

        <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
          <form action="/user/search" method="get" class="site-block-top-search">
            <span class="icon icon-search2"></span>
            <input type="text" name="search" class="form-control border-0" placeholder="Search" value="<?php echo isset($searchTerm) ? htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8') : ''; ?>">
          </form>
        </div>

        <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
          <div class="site-logo">
            <a href="/user/home" class="js-logo-clone">Fotheby</a>
          </div>
        </div>

        <div class="col-6 col-md-4 order-3 order-md-3 text-right">
          <div class="site-top-icons">
            <ul>
              <li class="nav-item dropdown no-arrow">
                <?php if (isset($_SESSION['userDetails'])) : ?>
                  <?php $userDetails = $_SESSION['userDetails']; ?>

                  <nav class="site-navigation text-right text-md-center" role="navigation">
                    <div class="container">
                      <ul class="site-menu">
                        <li class="has-children">
                          <?= htmlspecialchars($userDetails['firstname'] . ' ' . $userDetails['lastname']) ?>
                          <ul class="dropdown">
                            <li><a href="/user/edituser?userId=<?php echo $userDetails['userId'] ?>">Profile</a></li>
                            <?php if ($isSeller) : ?>
                            <li><a href="/user/addauction">Add An Auction</a></li>
                            <?php else : ?>
                              <li><a href="#">Request To be Seller</a></li>
                            <?php endif;?>
                            <div class="dropdown-divider"></div>
                            <li><a href="/user/logout">Logout</a></li>
                          </ul>
                        </li>
                      </ul>
                    </div>
                  </nav>
                <?php else : ?>
                  <nav class="site-navigation text-right text-md-center" role="navigation">
                    <ul class="site-menu">
                      <li class="has-children">
                        <span class="icon icon-person"></span>&nbsp;Login/Register
                        <ul class="dropdown">
                          <li><a href="/admin/login">Login</a></li>
                          <li><a href="/user/register">Register</a></li>
                        </ul>
                      </li>
                    </ul>
                  </nav>
                <?php endif; ?>
              </li>

            </ul>
          </div>
        </div>

      </div>
    </div>
  </div>
  <nav class="site-navigation text-right text-md-center" role="navigation">
    <div class="container">
      <ul class="site-menu js-clone-nav d-none d-md-block">
        <li><a href="/user/home">Home</a></li>
        <li class="has-children">
          <a href="/user/catalogue">Serivces</a>
          <ul class="dropdown">
            <li><a href="/user/catalogue">Submit a Bid</a></li>
          </ul>
        </li>
        <li><a href="/user/contact">Contact</a></li>
      </ul>
    </div>
  </nav>
</header>
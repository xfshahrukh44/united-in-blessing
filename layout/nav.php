  <?php $activePage = basename($_SERVER['PHP_SELF'], ".php"); ?>


  <header>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <a href="index.php"><img src="images/logo.png" alt=""></a>
        </div>
        <div class="col-md-6">
          <button class="menu-toggler" type="button" data-target="#overlayNavigation">
            <div class="d-inline-flex navbar-icon">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </button>
        </div>
      </div>
    </div>
  </header>
  <!-- navigation -->
  <div class="navigation-menu" id="overlayNavigation">
    <div class="navigation-bg one"></div>
    <div class="navigation-bg two"></div>
    <div class="container-fluid h-100">
      <div class="row h-100">
        <div class="offset-md-6 col-md-6 navigation-wrapper">
          <div class="nav-inner">
            <ul class="list-inline">
              <li class="nav-item">
                <a href="#" class="nav-link">HOME</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">ABOUT</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">WORKS</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">BLOG</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">CONTACT</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- navigation -->
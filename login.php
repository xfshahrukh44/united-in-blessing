<?php include 'layout/header.php'; ?>
<?php include 'layout/nav.php'; ?>

<main class="loginWrap">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="whitebg">
          <form class="formStyle">
            <div class="mb-4 text-center">
              <h2>Member Login</h2>
            </div>
            <div class="mb-4">
              <input type="text" class="form-control" placeholder="UserName">
              <div class="text-end"><a href="#">Forgot Username?</a></div>
            </div>
            <div class="mb-4">
              <input type="password" class="form-control" placeholder="Password">
              <div class="text-end"><a href="#">Forgot Password?</a></div>
            </div>
            <div class="mb-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">Remember Me</label>
              </div>
            </div>
            <div class="mb-4">
              <button class="themeBtn w-100"><span></span><text>Login</text></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
<!-- Begin: Store Category -->
<!-- END: Store Category -->

<?php include 'layout/footer.php'; ?>
<?php include 'layout/script.php'; ?>
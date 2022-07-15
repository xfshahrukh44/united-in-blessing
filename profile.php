<?php include 'layout/header.php'; ?>
<?php include 'layout/nav.php'; ?>

<main class="loginWrap">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="whitebg">
          <form class="formStyle row justify-content-between">
            <div class="col-md-12 text-center">
              <h2>Member Profile</h2>
            </div>
            <div class="col-md-12 mb-4">
              <div class="userProfileCard">
                <div class="profilePic">
                  <img class="profile-pic" src="images/user.jpg">
                  <div class="p-image">
                    <i class="fa fa-camera upload-button"></i>
                    <input class="file-upload" type="file" accept="image/*" />
                  </div>
                </div>
                <div class="profileDetl">
                  <h3>JohnSmith 123</h3>
                  <ul>
                    <li><a href="mailto:johnsmith22@gmail.com">Email: johnsmith22@gmail.com</a></li>
                    <li class="saperator"></li>
                    <li><a href="tel:+1234567890">Phone: +123 456 7890</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-4">
              <input type="text" class="form-control" placeholder="John">
            </div>
            <div class="col-md-6 mb-4">
              <input type="text" class="form-control" placeholder="Smith">
            </div>
            <div class="col-md-6 mb-4">
              <input type="phone" class="form-control" placeholder="+123 456 7890">
            </div>
            <div class="col-md-6 mb-4">
              <input type="email" class="form-control" placeholder="johnsmith22@gmail.com">
            </div>
            <div class="col-md-6 mb-4">
              <input type="text" class="form-control" placeholder="Password">
            </div>
            <div class="col-md-6 mb-4">
              <input type="text" class="form-control" placeholder="Confirm Password">
            </div>
            <div class="col-md-4">
              <button class="themeBtn w-100"><span></span><text>Update Now</text></button>
            </div>
            <div class="col-md-4">
              <button class="themeBtn w-100"><span></span><text>Exit</text></button>
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
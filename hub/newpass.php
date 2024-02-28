<?php 
  $title = "New password";
  require_once "db.php";
  include_once 'header.php';

  if(isset($_POST['submit'])){
    $email = $_SESSION['email'];
    $password = md5($_POST['password']);
    $confirmpassword = md5($_POST['confirmpassword']);

    if($password != $confirmpassword){
        echo "<script>swal('Password Mismatch!', 'Please try to re-enter your password', 'error');</script>";
    }
    else{

        $sql_update_user_pass = mysqli_query($conn,"UPDATE users SET password='$confirmpassword' WHERE email='$email'");
    
        if($sql_update_user_pass){
            unset($_SESSION['email']);
            echo "<script>swal({title: 'Password Changed', text: 'You can now login using your new password', icon: 
                'success'}).then(function(){ 
                    window.location.href = 'signin.php';
                  }
                );</script>";
        }
        else{
            echo "<script>swal('Failed!', 'Oops Something Went Wrong!', 'error');</script>";
        }  
    }
  }

?>
    <!-- End Navbar -->
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">New Password</h4>
                  <p class="mb-0">Please create your new password</p>
                </div>
                <div class="card-body">
                  <form method="POST" role="form">
                    <div class="mb-3">
                      <input type="password" class="form-control form-control-lg" name="password" placeholder="Create new password" required>
                      <input type="password" class="form-control form-control-lg mt-3" name="confirmpassword" placeholder="Confirm your password" required>
                    </div>
                    <div class="text-center">
                      <button type="submit" name="submit" class="btn btn-primary w-100">Change</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('../image/schoolg.jpg');
          background-size: cover;">
                <span class="mask bg-gradient-secondary opacity-5"></span>
                <h4 class="mt-5 text-white font-weight-bolder position-relative" style="font-size: 4em;">"RIKDO"</h4>
                <p class="text-white position-relative" style="font-size: 24px;">Research , Innovation and Knowledge Development Office of Columban College Inc.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>
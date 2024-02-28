<?php 
  $title = "Sign In";
  require_once "db.php";
  include_once 'header.php';

  $admin_unique = uniqid();
  $researcher_unique = uniqid();
  $adviser_unique = uniqid();

  if(isset($_POST['submit'])){
    $userid = $_POST['id'];
    $password = md5($_POST['password']);

    $check_account = mysqli_query($conn,"SELECT * FROM users WHERE idnum='$userid' AND password='$password' AND status='activated'");
    $check_status = mysqli_query($conn,"SELECT * FROM users WHERE idnum='$userid' AND password='$password' AND status='deactivated'");

    if(mysqli_num_rows($check_status) > 0){
      echo "<script>swal('Information!', 'Your account is deactivated nofity your admin or wait for activation!', 'info');</script>";
    }
    elseif(mysqli_num_rows($check_account) > 0){
      $row_user  = mysqli_fetch_assoc($check_account);
      $id = $row_user['id'];
      $firstname = $row_user['firstname'];
      $lastname = $row_user['lastname'];
      $role = $row_user['role'];

      date_default_timezone_set('Asia/Manila');
      //$date = date('d-m-y h:i:s');

      if($role == "Administrator"){
        $sql_login = mysqli_query($conn,"INSERT INTO account_log (account, log_in, unique_number) VALUES ('$id', now(), '$admin_unique')");
        $_SESSION['account_admin'] = $firstname . " " . $lastname;
        $_SESSION['idaccount_admin'] = $id;
        $_SESSION['admin_unique_id'] = $admin_unique;
        echo "<script>window.location.href = '../admin/admin_dashboard.php';</script>";
      }
      if($role == "Adviser"){
        $sql_login = mysqli_query($conn,"INSERT INTO account_log (account, log_in, unique_number) VALUES ('$id', now(), '$adviser_unique')");
        $_SESSION['account_adviser'] = $firstname . " " . $lastname;
        $_SESSION['idaccount_adviser'] = $id;
        $_SESSION['adviser_unique_id'] = $adviser_unique;
        echo "<script>window.location.href = '../adviser/dashboard.php';</script>";
      }
      if($role == "Graduates" || $role == "College" || $role == "Senior High School" || $role == "Faculty"){
        $sql_login = mysqli_query($conn,"INSERT INTO account_log (account, log_in, unique_number) VALUES ('$id', now(), '$researcher_unique')");
        $_SESSION['account_researcher'] = $firstname . " " . $lastname;
        $_SESSION['idaccount_researcher'] = $id;
        $_SESSION['researcher_unique_id'] = $researcher_unique;
        echo "<script>window.location.href = '../researcher/dashboard.php';</script>";
      }
    }
    else{
      echo "<script>swal('Failed!', 'Incorrect Username or Password!', 'error');</script>";
    }
  }

  if(isset($_GET['logout_id'])){
    $returned = $_GET['logout_id'];
    $sql_update_log = mysqli_query($conn,"UPDATE account_log SET log_out=now() WHERE unique_number='$returned'");
    if($sql_update_log){
      echo "<script>window.location.href = 'signin.php';</script>";
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
                  <h4 class="font-weight-bolder">Sign In</h4>
                  <p class="mb-0">Enter your username and password</p>
                </div>
                <div class="card-body">
                  <form method="POST" role="form">
                    <div class="mb-3">
                      <input type="text" class="form-control form-control-lg" name="id" placeholder="Username" aria-label="Username" required>
                    </div>
                    <div class="mb-3">
                      <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" aria-label="Password" required>
                    </div>
                    <div class="mb-3">
                      <a href="forgot.php" class="text-primary text-gradient font-weight-bold">Forgot password?</a>
                    </div>
                    <div class="text-center">
                      <button type="submit" name="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Don't have an account?
                    <a href="signup.php" class="text-primary text-gradient font-weight-bold">Register</a>
                  </p>
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
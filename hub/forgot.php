<?php 
  $title = "Forgot";
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  require_once '../mail/vendor/autoload.php';
  require_once "db.php";
  include_once 'header.php';

  if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $_SESSION['email'] = $email;

    $check_email = mysqli_query($conn,"SELECT email FROM users WHERE email='$email' AND status='activated'");

    if(mysqli_num_rows($check_email) > 0){

      $otp = uniqid();

      $sql_update_user_pass = mysqli_query($conn,"UPDATE users SET password='$otp' WHERE email='$email'");

      $mail = new PHPMailer(true);

      try {                      
        $mail->isSMTP();                                           
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = 'columbanrikdo@gmail.com';                     
        $mail->Password   = 'meudbhclvrhcsxwt';                               
        $mail->SMTPSecure = 'ssl';            
        $mail->Port       = 465;                                    
    
        $mail->setFrom('columbanrikdo@gmail.com');
        $mail->addAddress($email);
          
        $mail->isHTML(true);                                 
        $mail->Subject = 'Password Reset Code';
        $mail->Body    = 'Your password reset code is ' . $otp;
    
        $mail->send();
        $mail->ClearAllRecipients();
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }

      if($sql_update_user_pass){
        echo "<script>swal({title: 'OTP code has been sent to your email!', text: 'Please use the otp code for verification', icon: 
          'success'}).then(function(){ 
              window.location.href = 'codev.php';
             }
          );</script>";
      }
    }
    else{
      echo "<script>swal('This email does not exist!', 'The email address you entered does not exist', 'error');</script>";
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
                  <h4 class="font-weight-bolder">Forgot Password</h4>
                  <p class="mb-0">Enter your email address</p>
                </div>
                <div class="card-body">
                  <form method="POST" role="form">
                    <div class="mb-3">
                      <input type="text" class="form-control form-control-lg" name="email" placeholder="Enter Email" required>
                    </div>
                    <div class="text-center">
                      <button type="submit" name="submit" class="btn btn-primary w-100">Continue</button>
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
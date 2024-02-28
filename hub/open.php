<?php 
    $title = "Open Research";
    require_once "db.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once '../mail/vendor/autoload.php';
    include_once 'header.php';

    if(isset($_GET['fileid'])){
        $fileid = $_GET['fileid'];

        $result_view_file = mysqli_query($conn,"SELECT published_research.*,research_documents.*
        FROM published_research,research_documents
        WHERE published_research.document=research_documents.id AND published_research.document='$fileid'");
        $row_view_file  = mysqli_fetch_assoc($result_view_file);

        $filename = $row_view_file['file_names'];
        $research_title = $row_view_file['research_title'];
        
        if(isset($_POST['submit'])){
            $id = $_POST['id'];

            $check_account = mysqli_query($conn,"SELECT * FROM users WHERE idnum='$id' AND status='activated'");
            $credentials  = mysqli_fetch_assoc($check_account);

            if(mysqli_num_rows($check_account) > 0){

              $idnum = $credentials['idnum'];
              $name = $credentials['firstname'] . " " . $credentials['lastname'];
              $role = $credentials['role'];

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

                  $send_email = mysqli_query($conn,"SELECT email FROM users WHERE status='activated' AND role='Administrator'");
                  if(mysqli_num_rows($send_email) > 0){
                    while($send_email_row = mysqli_fetch_assoc($send_email)) {
                      $mail->addAddress($send_email_row['email']);
                    }
                  }

                  $mail->isHTML(true);                                 
                  $mail->Subject = 'Research Notification';
                  $mail->Body    = '<b>Researcher Infomartion</b> <br>ID number: ' . $idnum . '<br> Type: ' . $role . '<br> Name: ' . $name . '<br><br> This researcher opened a research document entitled: ' . $research_title;
              
                  $mail->send();
                  $mail->ClearAllRecipients();
              } catch (Exception $e) {
                  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
              }
              
              echo "<script>window.location.href = '../publish/$filename';</script>";
            }
            else{
                echo "<script>swal('ID number not found!', 'Please try to register and contact the admin to activate your account', 'error');</script>";
            }
        }
    }   
?>
<main class="main-content mt-0">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11" style="background-image: url('../image/schoolg2.jpg'); background-position: top;">
      <span class="mask bg-gradient-secondary opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Research Details</h1>
            <p class="text-lead text-white">Research, Innovation, and Knowledge Development Office</p>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
        <div class="row mt-lg-n12 mt-md-n11 mt-n10">
            <div class="col-xl-12 col-lg-12 col-md-12 mx-auto">
                <div class="card mt-4">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12" >
                                <div class="shadow-lg card card-plain mb-4">
                                    <div class="card-body">
                                    <form method="post">
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label style="font-size: 15px;">Enter ID number to open document</label>
                                                <input type="text" name="id" class="form-control form-control-alternative" required>
                                            </div>
                                        </div><br>
                                        <a href="research.php" class="btn btn-light w-100"><i class="fa fa-times"></i> Cancel</a>
                                        <button type="submit" name="submit" class="btn btn-dark w-100"><i class="fas fa-file"></i> Open Document</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </main><br><br>
  <?php 
  include 'footer.php';
?>
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
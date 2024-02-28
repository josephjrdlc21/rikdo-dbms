<?php 
    $title = "Versioning";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once '../mail/vendor/autoload.php';
    include_once 'header.php';

    if(isset($_GET['fileid'])){
        $fileid = $_GET['fileid'];

        $result_edit_file = mysqli_query($conn,"SELECT * FROM research_documents WHERE id='$fileid'");
        $row_edit_file  = mysqli_fetch_assoc($result_edit_file);

        $id = $row_edit_file['id'];
    }

    if(isset($_POST['submit'])){

        $id = $_POST['fileid'];

        $result_file = mysqli_query($conn,"SELECT * FROM research_documents WHERE id='$fileid'");
        $row_file  = mysqli_fetch_assoc($result_file);

        $sql_comments_file = mysqli_query($conn,"DELETE FROM comments WHERE document='$id'");
        $sql_actions_file = mysqli_query($conn,"DELETE FROM action_done WHERE document='$id'");

        $filename = $_FILES["file_name"]["name"];
        $tempname = $_FILES["file_name"]["tmp_name"];
        $folder = "../documents/" . $filename;

        if(!empty($filename)){
    
            $filename_exist = $row_file['file_names'];
            $uploader = $row_file['submitted_by'];
            $title = $row_file['research_title'];
            $ver = $row_file['version']+1;
            $adviser = $row_file['adviser'];
            $chapter = $row_file['chapter'];
            $authors = $row_file['authors'];

            unlink("../documents/". $filename_exist);

            $sql_update_research = mysqli_query($conn,"UPDATE research_documents SET file_names='$filename', date_submitted=now(), status='Pending', version=version+1 WHERE id='$id'");
            move_uploaded_file($tempname, $folder);

            $check_uploader = mysqli_query($conn,"SELECT * FROM users WHERE id='$uploader' LIMIT 1");
            $uploader_credentials  = mysqli_fetch_assoc($check_uploader);

            $idnum_uploader = $uploader_credentials['idnum'];
            $name_uploader = $uploader_credentials['firstname'] . " " . $uploader_credentials['lastname'];
            $role_uploader = $uploader_credentials['role'];

            $check_adviser = mysqli_query($conn,"SELECT * FROM users WHERE id='$adviser' LIMIT 1");
            $adviser_credentials  = mysqli_fetch_assoc($check_adviser);

            $name_adviser = $adviser_credentials['firstname'] . " " . $adviser_credentials['lastname'];
            $idnum_adviser = $adviser_credentials['idnum'];

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

                $send_email = mysqli_query($conn,"SELECT email FROM users WHERE (role='Administrator' AND status='activated') OR idnum='$idnum_adviser'");
                if(mysqli_num_rows($send_email) > 0){
                    while($send_email_row = mysqli_fetch_assoc($send_email)) {
                        $mail->addAddress($send_email_row['email']);
                    }
                }

                $mail->isHTML(true);                                 
                $mail->Subject = 'Research Notification';
                $mail->Body    = '<b>Researcher Infomartion</b> <br>ID number: ' . $idnum_uploader . '<br> Type: ' . $role_uploader . '<br> Name: ' . $name_uploader . 
                '<br><br>Researcher ' . $name_uploader .' submits version ' . $ver . ' of research entitled: ' . $title . "<br> Authors: " . $authors .
                "<br> Chapter: " . $chapter . "<br> Adviser: " . $name_adviser;
            
                $mail->send();
                $mail->ClearAllRecipients();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            if($sql_update_research){
                $activity = "Submits version " . $ver ." of research entitled " . $title;
                $activity_log_sql = mysqli_query($conn,"INSERT INTO activity_log (account, activity, created_at) VALUES ('$uploader', '$activity', now())");
                echo "<script>swal('New version submitted', 'New version of research has been submitted', 'success');</script>";
            }
 
        } 
    }
?>
    <!-- End Navbar -->
    <div class="container py-4">
        <div class="row">
            <div class="col-lg grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-primary">Research Versioning</h4>

                        <div class="row mt-4" style="overflow-x: auto;">

                            <div class="col-sm-12 col-md-12 col-lg-12" >
                                <div class="shadow-lg card card-plain mb-4">
                                    <div class="card-body">
                                        <form method="POST" enctype="multipart/form-data">

                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <div class='btn-group d-flex' role='group' style='overflow: auto;'>
                                                        <a href="view_file.php?fileid=<?php echo $fileid; ?>" class="btn btn-light"><i class="fas fa-reply"></i> Click to Return</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" class="form-control form-control-alternative" name="fileid" value="<?php echo $id ?>">

                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <label style="font-size: 15px;"> Attach new version of research file (doc, docx. Format) <span style="color: red;">*</span> </label>
                                                    <input class="form-control form-control-alternative" name="file_name" accept=".doc, .docx" type="file" required>
                                                </div>
                                            </div>
                                           
                                            <div class="row mt-4">
                                                <div class="col-sm-12">
                                                    <button type="submit" name="submit" class="btn btn-dark w-100 mt-2" onclick="return confirm('Are you sure you want to submit this research?')"><i class="fa fa-paper-plane"></i> Submit New Version of Research</button>
                                                </div>
                                            </div>
                                        </form>                     
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
  	</div>
    
  </main>
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
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
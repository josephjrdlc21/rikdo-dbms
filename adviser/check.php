<?php 
    $title = "Check Research";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once '../mail/vendor/autoload.php';
    include_once 'header.php';

    if(isset($_GET['fileid'])){
        $fileid = $_GET['fileid'];

        $result_edit_file = mysqli_query($conn,"SELECT * FROM research_documents WHERE id='$fileid'");
        $row_edit_file  = mysqli_fetch_assoc($result_edit_file);

        $id = $row_edit_file['id'];
        $stat = $row_edit_file['status'];
    }

    if(isset($_POST['submit'])){

        $checked = $_POST['check_research'];
        $id = $_POST['fileid'];

        $result_file = mysqli_query($conn,"SELECT * FROM research_documents WHERE id='$fileid'");
        $row_file  = mysqli_fetch_assoc($result_file);

        $filename = $_FILES["file_name"]["name"];
        $tempname = $_FILES["file_name"]["tmp_name"];
        $folder = "../documents/" . $filename;

        if(!empty($filename)){
    
            $filename_exist = $row_file['file_names'];
            $adviser = $row_file['adviser'];
            $title = $row_file['research_title'];
            $uploader = $row_file['submitted_by'];
            $version = $row_file['version'];
            $chapter = $row_file['chapter'];

            unlink("../documents/". $filename_exist);

            $sql_update_research = mysqli_query($conn,"UPDATE research_documents SET status='$checked', file_names='$filename' WHERE id='$id'");
            move_uploaded_file($tempname, $folder);

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

                $send_email = mysqli_query($conn,"SELECT email FROM users WHERE id='$uploader' LIMIT 1");
                $stud_email  = mysqli_fetch_assoc($send_email);
                
                $mail->addAddress($stud_email['email']);

                
                $mail->isHTML(true);                                 
                $mail->Subject = 'Research Notification';

                if($checked == "Approved"){
                    $mail->Body    = 'Your research entitled ' . $title . ' chapter ' . $chapter . '  version ' . $version . ' has been approved! ';
                }
                elseif($checked == "Revision"){
                    $mail->Body    = 'Your research entitled ' . $title . ' chapter ' . $chapter . '  version ' . $version . ' is in need of revision! ';
                }
                else{
                    $mail->Body    = 'Your research entitled ' . $title . ' chapter ' . $chapter . '  version ' . $version . ' has been rejected! ';
                }
            
                $mail->send();
                $mail->ClearAllRecipients();

            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            $activity = "Checks a research document entitled" . $title;
            $activity_log_sql = mysqli_query($conn,"INSERT INTO activity_log (account, activity, created_at) VALUES ('$adviser', '$activity', now())");

            if($sql_update_research){

                if($checked == "Approved"){
                    echo "<script>swal('Approved', 'This research has been approved', 'success');</script>";
                }
                elseif($checked == "Revision"){
                    echo "<script>swal('Revision', 'This research is in need of revision', 'warning');</script>";
                }
                else{
                    echo "<script>swal('Revision', 'This research has been rejected', 'error');</script>";
                }
            }
 
        }
        else{
            $adviser = $row_file['adviser'];
            $title = $row_file['research_title'];
            
            $sql_update_research = mysqli_query($conn,"UPDATE research_documents SET status='$checked' WHERE id='$id'");

            $activity = "Checks a research document entitled" . $title;
            $activity_log_sql = mysqli_query($conn,"INSERT INTO activity_log (account, activity, created_at) VALUES ('$adviser', '$activity', now())");

            if($sql_update_research){

                if($checked == "Approved"){
                    echo "<script>swal('Approved', 'This research has been approved', 'success');</script>";
                }
                elseif($checked == "Revision"){
                    echo "<script>swal('Revision', 'This research is in need of revision', 'warning');</script>";
                }
                else{
                    echo "<script>swal('Revision', 'This research has been rejected', 'error');</script>";
                }
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
                        <h4 class="card-title text-primary">Research Detail</h4>

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
                                                    <label style="font-size: 15px;">Select to Check Research <span style="color: red;">*</span> </label>
                                                    <select class="form-control form-control-alternative" name="check_research" required>
                                                        <option style="display: none;" selected></option>
                                                        <option value="Approved">Approve this Research</option>
                                                        <option value="Revision">Revision needed in this research</option>
                                                        <option value="Rejected">Reject this research</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <label style="font-size: 15px;"> Attach the checked file (doc, docx. Format) (optional)</label>
                                                    <input class="form-control form-control-alternative" name="file_name" accept=".doc, .docx" type="file">
                                                </div>
                                            </div>
                                           
                                            <div class="row mt-4">
                                                <div class="col-sm-12">
                                                    <button type="submit" name="submit" class="btn btn-dark w-100 mt-2" onclick="return confirm('Are you sure you want to return this research?')"
                                                    <?php 
                                                        if($stat <> "Pending"){
                                                            echo "disabled";
                                                        }
                                                    ?>
                                                    ><i class="fa fa-paper-plane"></i> Return Research</button>
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
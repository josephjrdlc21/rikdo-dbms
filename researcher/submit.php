<?php 
    $title = "Submit a file";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once '../mail/vendor/autoload.php';
    include_once 'header.php';

    $uploader = $_SESSION['idaccount_researcher'];

    if(isset($_POST['submit'])){

        $filename = $_FILES["file_name"]["name"];
        $tempname = $_FILES["file_name"]["tmp_name"];
        $folder = "../documents/" . $filename;

        $title = $_POST['title'];
        $authors= $_POST['authors'];
        $adviser = $_POST['adviser'];
        $degree_strand = $_POST['degree_strand'];
        $department = $_POST['department'];
        $type = $_POST['type_of_research'];
        $status = "Pending";
        $version = 1;

        if($type == "Proposal"){
            $chapter = 0;
        }
        else{
            $chapter = $_POST['chapter'];
        }

        if (file_exists($folder)) {
            echo "<script>swal('File Exist', 'File already exist please try again or rename the file', 'error');</script>";
        } 
        else {
            $sql_submit_file = mysqli_query($conn,"INSERT INTO research_documents (research_title, authors, degree_strand, department, 
            chapter, version, status, date_submitted, submitted_by, adviser, file_names, date_restore, instatus, type_r)
            VALUES ('$title', '$authors', '$degree_strand', '$department', $chapter, 1, '$status', now(), '$uploader', '$adviser', '$filename', now(), 'active', '$type')");

            if($sql_submit_file){
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

                $activity = "Submits a research paper entitled " . $title;
                $activity_log_sql = mysqli_query($conn,"INSERT INTO activity_log (account, activity, created_at) VALUES ('$uploader', '$activity', now())");
                
                
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
                    '<br><br>Researcher ' . $name_uploader .' submits a research document entitled: ' . $title . "<br> Authors: " . $authors .
                    "<br> Chapter: " . $chapter . "<br> Version: " . $version . "<br> Adviser: " . $name_adviser;
                
                    $mail->send();
                    $mail->ClearAllRecipients();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

                echo "<script>swal('File Submitted', 'Research File Successfully Submitted!', 'success');</script>";
            }
            else{
                echo "<script>swal('Failed!', 'Oops Something Went Wrong!', 'error');</script>";
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
                        <h4 class="card-title text-primary">Submit Research</h4>

                        <div class="row mt-4" style="overflow-x: auto;">

                            <div class="col-sm-12 col-md-12 col-lg-12" >
                                <div class="shadow-lg card card-plain mb-4">
                                    <div class="card-body">
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <label style="font-size: 15px;"> Attach a file (doc, docx. Format) <span style="color: red;">*</span> </label>
                                                    <input class="form-control form-control-alternative" name="file_name" accept=".doc, .docx" type="file" required>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <label style="font-size: 15px;">Research Title <span style="color: red;">*</span> </label>
                                                    <textarea class="form-control form-control-alternative" name="title" rows="3" required></textarea>
                                                </div>
                                            </div>

                                            <div class="row form-group">    
                                                <div class="col-sm-6">
                                                    <label style="font-size: 15px;">Select Type of Research <span style="color: red;">*</span> </label>
                                                    <select class="form-control form-control-alternative" name="type_of_research" required>
                                                        <option value="" selected disabled style="display: none; color: gray;">Click to choose</option>
                                                        <option value="Proposal">Proposal Research</option>
                                                        <option value="Capstone">Capstone Research</option>
                                                        <option value="Thesis">Thesis Research</option>
                                                        <option value="Dissertation">Dissertation Research</option>
                                                    </select>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label style="font-size: 15px;">Select Chapter <span style="color: red;">*</span> </label>
                                                    <select class="form-control form-control-alternative" name="chapter" required>
                                                        <option value="" selected disabled style="display: none; color: gray;">Click to choose</option>
                                                        <option value="1">Chapter 1</option>
                                                        <option value="2">Chapter 2</option>
                                                        <option value="3">Chapter 3</option>
                                                        <option value="4">Chapter 4</option>
                                                        <option value="5">Chapter 5</option>
                                                        <option value="6">Chapter 6</option>
                                                        <option value="7">Chapter 7</option>
                                                        <option value="0">None chapter research</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <label style="font-size: 15px;">Authors (e.g Joseph Dela Cruz, Gerson Capati, Joshua Hipolito) <span style="color: red;">*</span> </label>
                                                    <textarea class="form-control form-control-alternative" name="authors" rows="2" required></textarea>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                <label style="font-size: 15px;">Choose Adviser <span style="color: red;">*</span> </label>
                                                    <select class="form-control form-control-alternative" name="adviser" required>
                                                            <option value="" selected disabled style="display: none; color: gray;">Click to choose</option>
                                                            <?php 
                                                                $sql_select_adviser = mysqli_query($conn,"SELECT * FROM users WHERE role='Adviser' OR role='Administrator' AND status='activated'");
                                                                if (mysqli_num_rows($sql_select_adviser) > 0) {
                                                                    while($row_select_adviser = mysqli_fetch_assoc($sql_select_adviser)) {
                                                            ?>
                                                                <option value="<?= $row_select_adviser["id"];?>"><?= $row_select_adviser["lastname"] . ", " . $row_select_adviser["firstname"];?></option>
                                                            <?php 
                                                                    }
                                                                }
                                                            ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-6">
                                                    <label style="font-size: 15px;">Select Degree/Strand <span style="color: red;">*</span> </label>
                                                    <select class="form-control form-control-alternative" name="degree_strand" required>
                                                            <option value="" selected disabled style="display: none; color: gray;">Click to choose</option>
                                                            <?php 
                                                                $sql_select_degree = mysqli_query($conn,"SELECT * FROM degree_strand");
                                                                if (mysqli_num_rows($sql_select_degree) > 0) {
                                                                    while($row_select_degree = mysqli_fetch_assoc($sql_select_degree)) {
                                                            ?>
                                                                <option value="<?= $row_select_degree["id"];?>"><?= $row_select_degree["ds_code"] . " " . $row_select_degree["ds_name"];?></option>
                                                            <?php 
                                                                    }
                                                                }
                                                            ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label style="font-size: 15px;">Select Department <span style="color: red;">*</span> </label>
                                                    <select class="form-control form-control-alternative" name="department" required>
                                                        <option value="" selected disabled style="display: none; color: gray;">Click to choose</option>
                                                        <?php 
                                                            $sql_select_dept = mysqli_query($conn,"SELECT * FROM department");
                                                            if (mysqli_num_rows($sql_select_dept) > 0) {
                                                                while($row_select_dept = mysqli_fetch_assoc($sql_select_dept)) {
                                                        ?>
                                                            <option value="<?= $row_select_dept["id"];?>"><?= $row_select_dept["dept_code"] . " " . $row_select_dept["dept_name"];?></option>
                                                        <?php 
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-sm-12">
                                                    <button type="submit" name="submit" class="btn btn-dark w-100 mt-2" onclick="return confirm('Are you sure you want to submit this research?')"><i class="fa fa-upload"></i> Submit</button>
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
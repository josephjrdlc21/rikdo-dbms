<?php 
    $title = "Add Research File";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once '../mail/vendor/autoload.php';
    include_once 'header.php';

    if(isset($_POST['submit'])){
        $filename = $_FILES["file_name"]["name"];
        $tempname = $_FILES["file_name"]["tmp_name"];
        $folder = "../documents/" . $filename;

        $title = $_POST['title'];
        $authors= $_POST['authors'];
        $adviser = $_POST['adviser'];
        $degree_strand = $_POST['degree_strand'];
        $department = $_POST['department'];
        $chapter = $_POST['chapter'];
        $version = $_POST['version'];
        $status = "Pending";
        $researcher = $_POST['researcher'];

        if (file_exists($folder)) {
            echo "<script>swal('File Exist', 'File already exist please try again or rename the file', 'error');</script>";
        } else {
            $sql_submit_file = mysqli_query($conn,"INSERT INTO research_documents (research_title, authors, degree_strand, department, 
            chapter, version, status, date_submitted, submitted_by, adviser, file_names, date_restore, instatus)
            VALUES ('$title', '$authors', '$degree_strand', '$department', '$chapter', '$version', '$status', now(), '$researcher', '$adviser', '$filename', now(), 'active')");

            if($sql_submit_file){
                move_uploaded_file($tempname, $folder);

                $check_uploader = mysqli_query($conn,"SELECT * FROM users WHERE id='$researcher' LIMIT 1");
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
                    '<br><br>Researcher ' . $name_uploader .' submits a research document entitled: ' . $title . "<br> Authors: " . $authors .
                    "<br> Chapter: " . $chapter . "<br> Version: " . $version . "<br> Adviser: " . $name_adviser;
                
                    $mail->send();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

                echo "<script>swal('Research File Added', 'Research File Successfully Added!', 'success');</script>";
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
                        <h4 class="card-title text-primary">Add Research File</h4>

                        <div class="row mt-4" style="overflow-x: auto;">

                            <div class="col-sm-12 col-md-12 col-lg-12" >
                                <div class="shadow-lg card card-plain mb-4">
                                    <div class="card-body">
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <label style="font-size: 15px;"> Select a file (PDF Format)</label>
                                                    <input class="form-control form-control-alternative" name="file_name" accept=".pdf" type="file" required>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <label style="font-size: 15px;">Research Title</label>
                                                    <textarea class="form-control form-control-alternative" name="title" rows="3" required></textarea>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <label style="font-size: 15px;">Authors (e.g Joseph Dela Cruz, Gerson Capati, Joshua Hipolito)</label>
                                                    <textarea class="form-control form-control-alternative" name="authors" rows="2" required></textarea>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-6">
                                                <label style="font-size: 15px;">Adviser</label>
                                                    <select class="form-control form-control-alternative" name="adviser" required>
                                                            <option style="display: none;" selected></option>
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
                                                <div class="col-sm-6">
                                                <label style="font-size: 15px;">Submitted By</label>
                                                    <select class="form-control form-control-alternative" name="researcher" required>
                                                            <option style="display: none;" selected></option>
                                                            <?php 
                                                                $sql_select_researcher = mysqli_query($conn,"SELECT * FROM users WHERE (role='Faculty' OR role='Graduates' OR role='Senior High School' OR role='College') AND status='activated'");
                                                                if (mysqli_num_rows($sql_select_researcher) > 0) {
                                                                    while($row_select_researcher = mysqli_fetch_assoc($sql_select_researcher)) {
                                                            ?>
                                                                <option value="<?= $row_select_researcher["id"];?>"><?= $row_select_researcher["lastname"] . ", " . $row_select_researcher["firstname"];?></option>
                                                            <?php 
                                                                    }
                                                                }
                                                            ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-6">
                                                    <label style="font-size: 15px;">Degree/Strand</label>
                                                    <select class="form-control form-control-alternative" name="degree_strand" required>
                                                            <option style="display: none;" selected></option>
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
                                                    <label style="font-size: 15px;">Department</label>
                                                    <select class="form-control form-control-alternative" name="department" required>
                                                        <option style="display: none;" selected></option>
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

                                            <div class="row form-group">
                                                <div class="col-sm-6">
                                                    <label style="font-size: 15px;">Chapter</label>
                                                    <select class="form-control form-control-alternative" name="chapter" required>
                                                        <option style="display: none;" selected></option>
                                                        <option value="1.0">1.0</option>
                                                        <option value="2.0">2.0</option>
                                                        <option value="3.0">3.0</option>
                                                        <option value="4.0">4.0</option>
                                                        <option value="5.0">5.0</option>
                                                        <option value="Full">Full Chapter</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label style="font-size: 15px;">Version</label>
                                                    <select class="form-control form-control-alternative" name="version" required>
                                                        <option style="display: none;" selected></option>
                                                        <option value="1.0">1.0</option>
                                                        <option value="2.0">2.0</option>
                                                        <option value="3.0">3.0</option>
                                                        <option value="4.0">4.0</option>
                                                        <option value="5.0">5.0</option>
                                                    </select>
                                                </div>
                                            </div>
                                                    
                                            <div class="row mt-3">
                                                <div class="col-sm-12">
                                                    <a href="admin_cabinet.php" class="btn btn-light w-100 mt-2"><i class="fas fa-reply"></i> Back</a>
                                                    <button type="submit" name="submit" class="btn btn-success w-100" onclick="return confirm('Are you sure you want to submit this research?')"><i class="fa fa-upload"></i> Submit</button>
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
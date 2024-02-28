<?php 
    $title = "Add User";
    include_once 'header.php';

    $adviser = $_SESSION['idaccount_admin'];

    if(isset($_POST['submit'])){

        $filename = $_FILES["profile"]["name"];
        $tempname = $_FILES["profile"]["tmp_name"];
        $folder = "../profile/" . $filename;

        $idnum = $_POST['idnum'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $degree_strand = $_POST['degree_strand'];
        $department = $_POST['department'];
        $role = $_POST['role'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $status = "activated";
        $password = md5($_POST['password']);
        $confirmpassword = md5($_POST['confirmpassword']);

        $check_id = mysqli_query($conn,"SELECT idnum FROM users WHERE idnum='$idnum'");

        if(mysqli_num_rows($check_id) > 0){
            echo "<script>swal('Warning!', 'User ID already used!', 'warning');</script>";
        }
        elseif($password != $confirmpassword){
            echo "<script>swal('Failed!', 'Password Mismatch!', 'error');</script>";
        }
        else{
            $sql_add_user = mysqli_query($conn,"INSERT INTO users (idnum, firstname, lastname, degree_or_strand, dept, role, email, contact, password, profile, status, date_created)
            VALUES ('$idnum', '$firstname', '$lastname', '$degree_strand', '$department', '$role', '$email', '$contact', '$confirmpassword', '$filename', '$status',now())");
            move_uploaded_file($tempname, $folder);

            $activity = "Adds a user account ";
            $activity_log_sql = mysqli_query($conn,"INSERT INTO activity_log (account, activity, created_at) VALUES ('$adviser', '$activity', now())");
            
            if($sql_add_user){
                echo "<script>swal('Success', 'User Successfully Added!', 'success');</script>";
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
                        <h4 class="card-title text-primary">Add User</h4>

                        <div class="row mt-4" style="overflow-x: auto;">
                            
                            <div class="col-lg-12">
                                <div class="card card-plain mb-4">
                                    <div class="card-body">
                                    
                                        <form method="POST" enctype="multipart/form-data">

                                            <div class="row">
                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                    <div class="row form-group">
                                                        <div class="col-sm-3 col-form-label">
                                                            <label style="font-size: 15px;"><i class="fa fa-file-image" aria-hidden="true"></i> Add Profile:</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input class="form-control form-control-alternative" name="profile" accept="image/*" type="file">
                                                        </div>
                                                    </div>
                                                </div>
                                           
                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                    <div class="row form-group">
                                                        <div class="col-sm-3 col-form-label">
                                                            <label style="font-size: 15px;"><i class="fas fa-hashtag"></i> IDnumber: <span style="color: red;">*</span> </label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="idnum" class="form-control form-control-alternative" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                    <div class="row form-group">
                                                        <div class="col-sm-3 col-form-label">
                                                            <label style="font-size: 15px;"><i class="fa fa-user-circle"></i> Firstname: <span style="color: red;">*</span> </label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="firstname" class="form-control form-control-alternative" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                    <div class="row form-group">
                                                        <div class="col-sm-3 col-form-label">
                                                            <label style="font-size: 15px;"><i class="fa fa-user-circle"></i> Lastname: <span style="color: red;">*</span> </label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="lastname" class="form-control form-control-alternative" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                    <div class="row form-group">
                                                        <div class="col-sm-3 col-form-label">
                                                            <label style="font-size: 15px;"><i class="fa fa-graduation-cap"></i> Degree: <span style="color: red;">*</span> </label>
                                                        </div>
                                                        <div class="col-sm-9">
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
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                    <div class="row form-group">
                                                        <div class="col-sm-3 col-form-label">
                                                            <label style="font-size: 15px;"><i class="fa fa-building"></i> Department: <span style="color: red;">*</span> </label>
                                                        </div>
                                                        <div class="col-sm-9">
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
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                    <div class="row form-group">
                                                        <div class="col-sm-3 col-form-label">
                                                            <label style="font-size: 15px;"><i class='fas fa-user-tie' ></i> Role: <span style="color: red;">*</span> </label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <select class="form-control form-control-alternative" name="role" required>
                                                                <option value="" selected disabled style="display: none; color: gray;">Click to choose</option>
                                                                <option value="Administrator">Administrator</option>
                                                                <option value="Adviser">Adviser</option>
                                                                <option value="Faculty">Faculty</option>
                                                                <option value="Graduates">Graduates</option>
                                                                <option value="College">College</option>
                                                                <option value="Senior High School">Senior High School</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                    <div class="row form-group">
                                                        <div class="col-sm-3 col-form-label">
                                                            <label style="font-size: 15px;"><i class="fa fa-envelope"></i> Email: <span style="color: red;">*</span> </label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="email" class="form-control form-control-alternative" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-3 col-form-label">
                                                    <label style="font-size: 15px;"><i class="fa fa-phone-square"></i> Contact no.: <span style="color: red;">*</span> </label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" name="contact" class="form-control form-control-alternative" required>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-3 col-form-label">
                                                    <label style="font-size: 15px;"><i class="fas fa-key"></i> Password: <span style="color: red;">*</span></label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="password" name="password" class="form-control form-control-alternative" required>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-3 col-form-label">
                                                    <label style="font-size: 15px;"><i class="fas fa-lock"></i> Confirm Password: <span style="color: red;">*</span> </label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="password" name="confirmpassword" class="form-control form-control-alternative" required>
                                                </div>
                                            </div>

                                            <a href="users.php" class="btn btn-light w-100 mt-2"><i class="fas fa-reply"></i> Back</a>
                                            <button type="submit" name="submit" class="btn btn-dark w-100"><i class="fa fa-plus"></i> Add</button>
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
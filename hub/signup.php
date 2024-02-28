<?php 
  $title = "Sign Up";
  require_once "db.php";
  include_once 'header.php';

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
    $status = "deactivated";
    $password = md5($_POST['password']);
    $confirmpassword = md5($_POST['confirmpassword']);

    $check_id = mysqli_query($conn,"SELECT idnum FROM users WHERE idnum='$idnum'");

    if(mysqli_num_rows($check_id) > 0){
        echo "<script>swal('User ID already existing!', 'Please try again ID should be unique', 'warning');</script>";
    }
    elseif($password != $confirmpassword){
        echo "<script>swal('Password Mismatch!', 'Password does not match please try again', 'error');</script>";
    }
    else{
        $sql_register = mysqli_query($conn,"INSERT INTO users (idnum, firstname, lastname, degree_or_strand, dept, role, email, contact, password, profile, status, date_created)
        VALUES ('$idnum', '$firstname', '$lastname', '$degree_strand', '$department', '$role', '$email', '$contact', '$confirmpassword', '$filename', '$status', now())");
        move_uploaded_file($tempname, $folder);
        
        if($sql_register){
            echo "<script>swal('Success', 'Successfully Registered!', 'success');</script>";
        }
        else{
            echo "<script>swal('Failed!', 'Oops Something Went Wrong!', 'error');</script>";
        }
    }
  }
?>
    <!-- End Navbar -->
      <!-- End Navbar -->
  <main class="main-content mt-0">
    <div class="page-header align-items-start min-vh-100 pt-5 pb-11" style="background-image: url('../image/signup.jpg'); background-position: top;">
      <span class="mask bg-gradient-primary opacity-5"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-7 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Welcome!</h1>
            <p class="text-lead text-white">This is Research, Innovation and Knowledge Development Office of Columban College Inc.</p>

            <div class="card mb-2 mt-5">
              <div class="card-header text-center">
                <h5>Register</h5>
              </div>
              <div class="card-body">

                <form method="POST" enctype="multipart/form-data" role="form">

                  <div class="row form-group">
                    <div class="col-md-12 mb-3">
                        <input type="text" class="form-control" name="idnum" placeholder="Id number" required>
                    </div>
                  </div>

                  <div class="row form-group">
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" name="firstname" placeholder="Firstname" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control " name="lastname" placeholder="Lastname" required>
                    </div>
                  </div>

                  <div class="row form-group">
                    <div class="col-md-12 mb-3">
                        <select class="form-control " name="role" required>
                            <option selected disabled style="display: none;" class="text-secondary">Select Role</option>
                            <option value="Adviser">Adviser</option>
                            <option value="Faculty">Faculty</option>
                            <option value="Graduates">Graduates</option>
                            <option value="College">College</option>
                            <option value="Senior High School">Senior High School</option>
                        </select>
                    </div>
                  </div>

                  <div class="row form-group">
                    <div class="col-md-6 mb-3">
                        <select class="form-control" name="department" required>
                            <option value="" selected disabled style="display: none;" class="text-secondary">Select Department</option>
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
                    <div class="col-md-6">
                        <select class="form-control" name="degree_strand" required>
                            <option value="" selected disabled style="display: none; color: gray;">Select Degree/Strand</option>
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

                  <div class="row form-group">
                    <div class="col-sm-6 mb-3">
                        <input type="text" class="form-control" name="email" placeholder="Email" required>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="contact" placeholder="Contact" required>
                    </div>
                  </div>

                  <div class="row form-group">
                    <div class="col-sm-6 mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm Password" required>
                    </div>
                  </div>

                  <div class="row form-group">
                    <div class="col-sm-12">
                        <label>Upload profile pic</label>
                        <input class="form-control " title="upload profile" name="profile"  accept="image/*" type="file" required>
                    </div>
                  </div>

                  <div class="text-center">
                  <button type="submit" name="submit" class="btn bg-gradient-dark w-100 mb-2">Submit</button>
                  </div>

                  <p class="text-sm text-center mt-3 mb-0">Already have an account? <a href="signin.php" class="text-primary font-weight-bolder">Sign in</a></p>
                </form>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
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
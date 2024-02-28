<?php 
    $title = "My Profile";
    include_once 'header.php';

    if(isset($_SESSION['idaccount_researcher'])){
        $editid = $_SESSION['idaccount_researcher'];

        $result_edit_user = mysqli_query($conn,"SELECT * FROM users WHERE id='$editid'");
        $row_edit_user  = mysqli_fetch_assoc($result_edit_user);

        $id = $row_edit_user['id'];
        $firstname = $row_edit_user['firstname'];
        $lastname = $row_edit_user['lastname'];
        $degree_strand = $row_edit_user['degree_or_strand'];
        $department = $row_edit_user['dept'];
        $role = $row_edit_user['role'];
        $email = $row_edit_user['email'];
        $contact = $row_edit_user['contact'];
        $profile = $row_edit_user['profile'];
    }
?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-primary">My Profile</h4>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="shadow-lg card mb-4">
                                    <div class="card-body text-center">
                                        <img src="../profile/<?= $profile;?>" alt="avatar"
                                        class="rounded-circle img-fluid" style="width: 150px; height: 140px;">
                                        <h5 class="my-3"><?php echo $firstname . " " . $lastname; ?></h5>
                                        <p class="text-muted mb-1"><?php echo $role; ?></p><br>
                                        <div class="d-flex justify-content-center mb-2">
                                        <a href="change_pass.php" class="btn btn-success"> <i class='fas fa-key' ></i> Change Password</a>
                                        <a href="change_pic.php" class="btn btn-info" style="margin-left: 10px;"> <i class='fa fa-file-image' ></i> Change Profile</a>
                                    </div>
                                </div>
                            </div>
                            
                            </div>

                            <div class="col-lg-8">
                                <div class="shadow-lg card mb-4">
                                    <div class="card-body">
                                    
                                        <form method="POST" style="margin-left: 30px; margin-right: 30px;">

                                        <input type="hidden" class="form-control form-control-alternative" name="editid" value="<?php echo $id ?>" disabled>

                                            <div class="row form-group">
                                                <div class="col-sm-3 col-form-label">
                                                    <label style="font-size: 15px;"><i class="fa fa-user-circle"></i> First name:</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" name="firstname" class="form-control form-control-alternative" value="<?php echo $firstname ?>" disabled>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-3 col-form-label">
                                                    <label style="font-size: 15px;"><i class="fa fa-user-circle"></i> Last name:</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" name="lastname" class="form-control form-control-alternative" value="<?php echo $lastname ?>" disabled>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-3 col-form-label">
                                                    <label style="font-size: 15px;"><i class="fa fa-graduation-cap"></i> Degree/Strand:</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-control-alternative" name="degree_strand" disabled>
                                                        <?php 
                                                            $sql_select_degree = mysqli_query($conn,"SELECT * FROM degree_strand");
                                                            if (mysqli_num_rows($sql_select_degree) > 0) {
                                                                while($row_select_degree = mysqli_fetch_assoc($sql_select_degree)) {
                                                        ?>
                                                            <option value="<?= $row_select_degree["id"];?>" <?php if($degree_strand == $row_select_degree["id"]){ echo 'selected';}?>><?= $row_select_degree["ds_code"] . " " . $row_select_degree["ds_name"];?></option>
                                                        <?php 
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-3 col-form-label">
                                                    <label style="font-size: 15px;"><i class="fa fa-building"></i> Department:</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-control-alternative" name="department" disabled>
                                                        <?php 
                                                            $sql_select_dept = mysqli_query($conn,"SELECT * FROM department");
                                                            if (mysqli_num_rows($sql_select_dept) > 0) {
                                                                while($row_select_dept = mysqli_fetch_assoc($sql_select_dept)) {
                                                        ?>
                                                            <option value="<?= $row_select_dept["id"];?>" <?php if($department == $row_select_dept["id"]){ echo 'selected';}?>><?= $row_select_dept["dept_code"] . " " . $row_select_dept["dept_name"];?></option>
                                                        <?php 
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-3 col-form-label">
                                                    <label style="font-size: 15px;"><i class='fas fa-user-tie' ></i> Position:</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-control-alternative" disabled>
                                                        <option value="Administrator" <?php if($role == "Administrator"){ echo 'selected';}?>>Administrator</option>
                                                        <option value="Adviser" <?php if($role == "Adviser"){ echo 'selected';}?>>Adviser</option>
                                                        <option value="Faculty" <?php if($role == "Faculty"){ echo 'selected';}?>>Faculty</option>
                                                        <option value="Graduates" <?php if($role == "Graduates"){ echo 'selected';}?>>Graduates</option>
                                                        <option value="College" <?php if($role == "College"){ echo 'selected';}?>>College</option>
                                                        <option value="Senior High School" <?php if($role == "Senior High School"){ echo 'selected';}?>>Senior High School</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-3 col-form-label">
                                                    <label style="font-size: 15px;"><i class="fa fa-envelope"></i> Email:</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" name="email" class="form-control form-control-alternative" value="<?php echo $email ?>" disabled>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-3 col-form-label">
                                                    <label style="font-size: 15px;"><i class="fa fa-phone-square"></i> Contact no.:</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" name="contact" class="form-control form-control-alternative" value="<?php echo $contact ?>" disabled>
                                                </div>
                                            </div>
                                            <small style="text-align: justify; font-style: italic;">
                                                Under R.A. 10173, this personal data is treated almost literally in the same way as your own personal property. Thus, it should never be collected, processed and stored by any organization without the owner explicit consent, unless otherwise provided by law.
                                            </small>
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
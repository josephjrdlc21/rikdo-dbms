<?php 
    $title = "Change Profile Picture";
    include_once 'header.php';

    if(isset($_SESSION['idaccount_admin'])){
        $editid = $_SESSION['idaccount_admin'];

        $result_edit_profile = mysqli_query($conn,"SELECT * FROM users WHERE id='$editid'");
        $row_edit_profile = mysqli_fetch_assoc($result_edit_profile);

        $id = $row_edit_profile['id'];
        $profile = $row_edit_profile['profile'];
        $firstname = $row_edit_profile['firstname'];
        $lastname = $row_edit_profile['lastname'];
        $role = $row_edit_profile['role'];

    }

    if(isset($_POST['change_profile'])){
        $id = $_POST['editid'];

        $sql_del_old = mysqli_query($conn,"SELECT profile FROM users WHERE id='$id'");
        $row_del_pic  = mysqli_fetch_assoc($sql_del_old);
        $old_profile = $row_del_pic['profile'];

        unlink("../profile/". $old_profile);

        $filename = $_FILES["profile"]["name"];
        $tempname = $_FILES["profile"]["tmp_name"];
        $folder = "../profile/" . $filename;

        $sql_update_user_pass = mysqli_query($conn,"UPDATE users SET profile='$filename' WHERE id='$id'");
        move_uploaded_file($tempname, $folder);

        if($sql_update_user_pass){
            echo "<script>window.location.reload();</script>";
        }
        else{
            echo "<script>swal('Failed!', 'Oops Something Went Wrong!', 'error');</script>";
        }
      
    }
?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-primary">Change Profile Picture</h4>
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
                                        <a href="admin_password.php" class="btn btn-success"> <i class='fas fa-key' ></i> Change Password</a>
                                        <a href="admin_change_prof.php" class="btn btn-info" style="margin-left: 10px;"> <i class='fa fa-file-image' ></i> Change Profile</a>
                                    </div>
                                </div>
                            </div>
                            
                            </div>

                            <div class="col-lg-8">
                                <div class="shadow-lg card mb-4">
                                    <div class="card-body">
                                    
                                        <form method="POST" enctype="multipart/form-data" style="margin-left: 30px; margin-right: 30px;">

                                            <input type="hidden" class="form-control form-control-alternative" name="editid" value="<?php echo $id ?>">

                                            <div class="row form-group">
                                                <div class="col-sm-3 col-form-label">
                                                    <label style="font-size: 15px;"><i class="fa fa-file-image" aria-hidden="true"></i> Change Profile Pic:</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input class="form-control form-control-alternative" accept="image/*" type="file" name="profile" required>
                                                </div>
                                            </div>

                                            <a href="admin_profile.php" class="btn btn-light w-100"><i class="fas fa-reply"></i> Back</a>
                                            <button type="submit" name="change_profile" class="btn btn-dark w-100" onclick="return confirm('Are you sure you want to change profile?')"><i class="fa fa-pencil-square"></i> Save</button>
                                            <small style="text-align: justify; font-style: italic;">
                                                Under R.A. 10173, this personal data is treated almost literally in the same way as your own personal property. Thus, it should never be collected, processed and stored by any organization without your explicit consent, unless otherwise provided by law.
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

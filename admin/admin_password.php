<?php 
    $title = "Change Password";
    include_once 'header.php';

    if(isset($_SESSION['idaccount_admin'])){
        $editid = $_SESSION['idaccount_admin'];

        $result_edit_password = mysqli_query($conn,"SELECT * FROM users WHERE id='$editid'");
        $row_edit_password  = mysqli_fetch_assoc($result_edit_password);

        $id = $row_edit_password['id'];

    }

    if(isset($_POST['submit'])){
        $id = $_POST['editid'];
        $currentpassword = md5($_POST['currentpassword']);
        $newpassword = md5($_POST['password']);
        $confirmpassword = md5($_POST['confirmpassword']);

        if($currentpassword != $row_edit_password['password']){
            echo "<script>swal('Failed!', 'Current Password Is Wrong!', 'error');</script>";
        }
        else{

            if($newpassword != $confirmpassword){
                echo "<script>swal('Failed!', 'Password Mismatch!', 'error');</script>";
            }
            else{
                $sql_update_user_pass = mysqli_query($conn,"UPDATE users SET password='$confirmpassword' WHERE id='$id'");
    
                if($sql_update_user_pass){
                    echo "<script>swal('Success', 'Password Changed Sucessfully!', 'success');</script>";
                }
                else{
                    echo "<script>swal('Failed!', 'Oops Something Went Wrong!', 'error');</script>";
                }   
            }
            
        }
    }
?>
    <!-- End Navbar -->
    <div class="container py-4">
        <div class="row">
            <div class="col-lg grid-margin stretch-card">
                <div class="shadow card">
                        <h4 class="text-center text-primary mt-3">Change Password</h4>
                    <div class="card-body">

                    <form method="POST" style="margin-left: 30px; margin-right: 30px;">
                        <input type="hidden" class="form-control form-control-alternative" name="editid" value="<?php echo $id ?>">
                        <div class="row form-group">
                            <div class="col-sm-3 col-form-label">
                                <label style="font-size: 15px;"><i class='fas fa-user-lock' ></i> Current Password:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" name="currentpassword" class="form-control form-control-alternative" >
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-3 col-form-label">
                                <label style="font-size: 15px;"><i class='fas fa-key' ></i> New Password:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" name="password" class="form-control form-control-alternative" >
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-3 col-form-label">
                                <label style="font-size: 15px;"><i class="fa fa-lock"></i> Confirm New Password:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" name="confirmpassword" class="form-control form-control-alternative" >
                            </div>
                        </div>

                        <a href="admin_profile.php" class="btn btn-light w-100"><i class="fas fa-reply"></i> Back</a>
                        <button type="submit" name="submit" class="btn btn-dark w-100"><i class='fas fa-key' ></i> Save</button>
                    </form>
                    
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
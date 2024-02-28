<?php 
    $title = "Users";
    include_once 'header.php';

    $adviser = $_SESSION['idaccount_admin'];

    if (isset($_GET['page_no']) && $_GET['page_no']!="") {
        $page_no = $_GET['page_no'];
    } 
    else {
        $page_no = 1;
    }

    $total_records_per_page = 7;

    $offset = ($page_no-1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacents = "2";

    if(isset($_GET['status_filter']) && $_GET['status_filter'] != "all"){
        $filter = $_GET['status_filter'];

        $result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM users WHERE role='$filter'");
        $total_records = mysqli_fetch_array($result_count);
        $total_records = $total_records['total_records'];
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1;

        $users_list = "SELECT * FROM users WHERE role='$filter' ORDER BY date_created DESC LIMIT $offset, $total_records_per_page";
        $users_list_result = mysqli_query($conn, $users_list);
    }
    else{
        $filter="all";

        $result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM users");
        $total_records = mysqli_fetch_array($result_count);
        $total_records = $total_records['total_records'];
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1;

        $users_list = "SELECT * FROM users ORDER BY date_created DESC LIMIT $offset, $total_records_per_page";
        $users_list_result = mysqli_query($conn, $users_list);

    }

    if(isset($_GET['st']) && isset($_GET['ad'])){
        $id = $_GET['st'];
        $status = $_GET['ad'];

        $sql_update_user_status = mysqli_query($conn,"UPDATE users SET status='$status' WHERE id='$id'");

        if($sql_update_user_status && $status=="activated"){
            $activity = "Activate a user account";
            $activity_log_sql = mysqli_query($conn,"INSERT INTO activity_log (account, activity, created_at) VALUES ('$adviser', '$activity', now())");
            echo "<script>swal({title: 'Activated', text: 'You activate an account!', icon: 
                'success'}).then(function(){ 
                    window.location.href = 'users.php';
                   }
                );</script>";
        }else{
            if($sql_update_user_status){
                $activity = "Deactivate a user account";
                $activity_log_sql = mysqli_query($conn,"INSERT INTO activity_log (account, activity, created_at) VALUES ('$adviser', '$activity', now())");
                echo "<script>swal({title: 'Deactivated', text: 'You deactivate an account!', icon: 
                    'error'}).then(function(){ 
                        window.location.href = 'users.php';
                       }
                    );</script>";
            }
        }
    }


    if(isset($_POST['submit'])){
        if(isset($_POST['user_id'])){
            foreach($_POST['user_id'] as $user_id){

                $sql_del_old = mysqli_query($conn,"SELECT profile FROM users WHERE id='$user_id'");
                $row_del_pic  = mysqli_fetch_assoc($sql_del_old);
                $old_profile = $row_del_pic['profile'];

                unlink("../profile/". $old_profile);

                $sql_delete_log = mysqli_query($conn,"DELETE FROM account_log WHERE account='$user_id'");
                $sql_delete_activity = mysqli_query($conn,"DELETE FROM activity_log WHERE account='$user_id'");

                if($sql_delete_log){
                    $sql_delete_user = mysqli_query($conn,"DELETE FROM users WHERE id='$user_id'");
                }
            }
            $activity = "Deletes a user accounts";
            $activity_log_sql = mysqli_query($conn,"INSERT INTO activity_log (account, activity, created_at) VALUES ('$adviser', '$activity', now())");
            echo "<script>swal({title: 'Delete Account', text: 'Deleting a record successfully done!', icon: 
                'success'}).then(function(){ 
                    window.location.href = 'users.php';
                   }
                );</script>";
        }
    }
?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 style="overflow-x: auto;" class="text-primary">Users</h4>

                        <div class="row mt-4" style="overflow-x: auto;">
                            <div class="col-lg-12">

                                <div class="form-group" style="float: left; margin-right: 1rem;">
                                    <input class="form-control form-control-alternative" placeholder="Search" id=search type="text" style="width: 15rem;">
                                </div>  

                                <form method="GET" style="float: left;">
                                    <div class="form-group">
                                        <select class="form-control form-control-alternative" name="status_filter" onchange="this.form.submit()" style="width: 7rem;">
                                            <option value="all" <?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == "all"){ echo "selected";} ?>>Select Role</option>
                                            <option value="Administrator" <?php if (isset($_GET['status_filter']) && $_GET['status_filter'] == "Administrator"){ echo "selected";} ?>>Admin</option>
                                            <option value="Adviser" <?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == "Adviser"){ echo "selected";} ?>>Adviser</option>
                                            <option value="Faculty" <?php if (isset($_GET['status_filter']) && $_GET['status_filter'] == "Faculty"){ echo "selected";} ?>>Faculty</option>
                                            <option value="Graduates" <?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == "Graduates"){ echo "selected";} ?>>Graduates</option>
                                            <option value="College" <?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == "College"){ echo "selected";} ?>>College</option>
                                            <option value="Senior High School" <?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == "Senior High School"){ echo "selected";} ?>>Senior High</option>
                                        </select>  
                                    </div>  
                                </form>

                                <form action="users.php" method="POST">
                                    <div class="btn-group" role="group" style="float: right;">
                                        <a href="add_user.php" class="btn btn-dark"><i class="fa fa-plus"></i> Add User</a>
                                        <button type="submit" name="submit" class="btn btn-dark"  onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash"></i> Delete User</button>
                                    </div>

                                <table id="table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkAll"></th>
                                            <th>Profile</th>
                                            <th>ID</th>
                                            <th>User Role</th>
                                            <th>Full Name</th>
                                            <th>Status</th>
                                            <th>Date Joined</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="output">
                                    <?php
                                        if (mysqli_num_rows($users_list_result) > 0) {
                                            while($row_user_list = mysqli_fetch_array($users_list_result)) {
                                    ?>
                                        <tr>
                                            <td><input type="checkbox" class="checkItem" value="<?= $row_user_list["id"];?>" name="user_id[]"
                                            <?php 
                                                $this_id = $row_user_list["id"];
                                                $check_research_exits = mysqli_query($conn,"SELECT * FROM research_documents WHERE submitted_by='$this_id' OR adviser='$this_id' LIMIT 1");

                                                if(mysqli_num_rows($check_research_exits) > 0){
                                                    echo "disabled";
                                                }
                                            ?>
                                            ></td>
                                            <td><img src="../profile/<?= $row_user_list["profile"];?>" class="shadow rounded-circle" alt="profile" height="50px" width="50px"></td>
                                            <td><?= $row_user_list["idnum"];?></td>
                                            <td><?= $row_user_list["role"];?></td>
                                            <td><?= $row_user_list["firstname"] . " " . $row_user_list["lastname"];?></td>
                                            <td>
                                                <?php 
                                                    if($row_user_list["status"] == "deactivated"){
                                                ?>
                                                        <span class="badge badge-sm bg-gradient-danger">
                                                        <a href="users.php?ad=activated&&st=<?= $row_user_list["id"];?>" class="text-white" onclick="return confirm('Are you sure you want to activate?')">Deactivated</a>
                                                        </span>
                                                
                                                <?php 
                                                    }
                                                    else{
                                                ?> 
                                                        <span class="badge badge-sm bg-gradient-success">
                                                        <a href="users.php?ad=deactivated&&st=<?= $row_user_list["id"];?>" class="text-white" onclick="return confirm('Are you sure you want to deactivate?')">Activated</a>
                                                        </span>
                                                
                                                <?php 
                                                    }
                                                ?> 
                                                                                         
                                            </td>
                                            <td><?php echo date("F j, Y", strtotime($row_user_list["date_created"])); ?></td>
                                            <td><a href="view_users.php?editid=<?= $row_user_list["id"];?>" type="button" class="btn btn-sm btn-info" ><i class="fa fa-user-circle"></i> View</a></td>
                                        </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                    </tbody>
                                </form>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-3" style="overflow-x: auto;">
                            <div class="col-md-6">
                                <small>Total: <?php echo $total_records;?></small>
                            </div>
                            <div class="col-md-6">
                                <ul class="pagination pagination-sm justify-content-end">
                                <?php if($page_no > 1){ echo "<li class='page-item'><a class='page-link'  href='?page_no=1&&status_filter=$filter'><i class='fa fa-angle-double-left'></i></a></li>"; } ?>
    
                                    <li class="page-item" <?php if($page_no <= 1){ echo "class='page-item disabled'"; } ?>>
                                    <a class="page-link" <?php if($page_no > 1){ echo "href='?page_no=$previous_page&&status_filter=$filter'"; } ?>><i class="fa fa-angle-left"></i></a>
                                    </li>
                                    
                                    <?php 
                                        if ($total_no_of_pages <= 10){  	 
                                            for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                                                if ($counter == $page_no) {
                                                    echo "<li class='page-item active'><a class='page-link' style='color: white;'>$counter</a></li>";	
                                                }
                                                else{
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&&status_filter=$filter'>$counter</a></li>";
                                                }
                                            }
                                        }
                                        elseif($total_no_of_pages > 10){
                                        
                                            if($page_no <= 4) {			
                                                for ($counter = 1; $counter < 8; $counter++){		 
                                                    if ($counter == $page_no) {
                                                        echo "<li class='page-item active'><a class='page-link' style='color: white;'>$counter</a></li>";	
                                                    }
                                                    else{
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&&status_filter=$filter'>$counter</a></li>";
                                                    }
                                                }
                                                echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last&&status_filter=$filter'>$second_last</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages&&status_filter=$filter'>$total_no_of_pages</a></li>";
                                            }

                                            elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=1&&status_filter=$filter'>1</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=2&&status_filter=$filter'>2</a></li>";
                                                echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                                for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
                                                    if ($counter == $page_no) {
                                                        echo "<li class='page-item active'><a class='page-link' style='color: white;'>$counter</a></li>";	
                                                    }
                                                    else{
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&&status_filter=$filter'>$counter</a></li>";
                                                    }                  
                                                }
                                                echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last&&status_filter=$filter'>$second_last</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages&&status_filter=$filter'>$total_no_of_pages</a></li>";      
                                            }
                                            
                                            else {
                                            echo "<li class='page-item'><a class='page-link' href='?page_no=1&&status_filter=$filter'>1</a></li>";
                                            echo "<li class='page-item'><a class='page-link' href='?page_no=2&&status_filter=$filter'>2</a></li>";
                                            echo "<li class='page-item'><a class='page-link'>...</a></li>";

                                                for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                                    if ($counter == $page_no) {
                                                        echo "<li class='page-item active'><a class='page-link' style='color: white;'>$counter</a></li>";	
                                                    }
                                                    else{
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&&status_filter=$filter'>$counter</a></li>";
                                                    }                   
                                                }
                                            }
                                        }
                                    ?>
                                    
                                    <li class='page-item' <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
                                    <a class='page-link' <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page&&status_filter=$filter'"; } ?>><i class="fa fa-angle-right"></i></a>
                                    </li>
                                    <?php if($page_no < $total_no_of_pages){
                                            echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages&&status_filter=$filter'><i class='fa fa-angle-double-right'></i></a></li>";
                                        } 
                                    ?>  
                                </ul>
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

    $(document).ready(function(){

        $("#checkAll").click(function(){
            if($(this).is(":checked")){
                $('.checkItem:not(:disabled)').prop('checked', true);
            } else {
                $('.checkItem').prop('checked', false);
            }
        });

        $("#search").keyup(function(){

        var input = $("#search").val();
        $.ajax({
            url:"usersearch.php",
            method:"POST",
            data:{input:input},
                success:function(data){
                    $("#output").html(data);
                }
            })
        });
    });
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>
</html>
<?php 
    $title = "Account Log";
    include_once 'header.php';
    
    $adviser = $_SESSION['idaccount_admin'];

    if (isset($_GET['page_no']) && $_GET['page_no']!="") {
        $page_no = $_GET['page_no'];
    } 
    else {
        $page_no = 1;
    }

    if(isset($_GET['status_filter'])){
        $filter = $_GET['status_filter'];
        $_SESSION['year'] = $filter;
    }
    else{
        $filter = $current_year = date('Y');
        $_SESSION['year'] = $filter;
    }

    $total_records_per_page = 7;

    $offset = ($page_no-1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacents = "2";

    $result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM account_log WHERE YEAR(log_in)=$filter OR YEAR(log_out)=$filter");
    $total_records = mysqli_fetch_array($result_count);
    $total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
    $second_last = $total_no_of_pages - 1;

    $users_log = "SELECT account_log.*,users.profile,users.role,users.idnum,users.firstname,users.lastname FROM account_log,users 
    WHERE account_log.account=users.id  AND (YEAR(log_in)=$filter OR YEAR(log_out)=$filter) ORDER BY account_log.id DESC LIMIT $offset, $total_records_per_page";
    $users_list_log = mysqli_query($conn, $users_log);

    if(isset($_POST['submit'])){
        if(isset($_POST['file_id'])){
            foreach($_POST['file_id'] as $file_id){

                $sql_delete_log = mysqli_query($conn,"DELETE FROM account_log WHERE id='$file_id'");
            }
            $activity = "Deletes an account log ";
            $activity_log_sql = mysqli_query($conn,"INSERT INTO activity_log (account, activity, created_at) VALUES ('$adviser', '$activity', now())");
            echo "<script>swal({title: 'User log Deleted', text: 'User log deleted successfully!', icon: 
                'success'}).then(function(){ 
                    window.location.href = 'admin_account_log.php';
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
                        <h4 style="overflow-x: auto;" class="text-primary">Account Log</h4>
                        
                        <div class="row mt-4" style="overflow-x: auto;">
                            <div class="col-lg-12">

                                <div class="form-group" style="float: left; margin-right: 1rem;">
                                    <input class="form-control form-control-alternative" placeholder="Search" id=search type="text" style="width: 15rem;">
                                </div>

                                <form method="GET" style="float: left;">
                                    <div class="form-group">
                                        <?php 
                                        $year_start  = 2019;
                                        $year_end = date('Y');
                                        $user_selected_year = $filter;

                                        echo '<select class="form-control form-control-alternative" name="status_filter" onchange="this.form.submit()" style="width: 7rem;">';
                                        for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
                                                $selected = ($user_selected_year == $i_year ? ' selected' : '');
                                                echo '<option value="'.$i_year.'"'.$selected.'>'.$i_year.'</option>'."\n";
                                        }
                                            echo '</select>';
                                        ?>
                                    </div>
                                </form>

                                <form action="admin_account_log.php" method="POST">
                                    <div class="btn-group" role="group" style="float: right;">
                                        <button type="submit" name="submit" class="btn btn-dark"  onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash"></i> Delete</button>
                                    </div>

                                <table id="table">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkAll"></th>
                                        <th>Profile</th>
                                        <th>ID</th>
                                        <th>User Role</th>
                                        <th>Fullname</th>
                                        <th>Log in Date/Time</th>
                                        <th>Log out Date/Time</th>
                                    </tr>
                                    </thead>
                                    <tbody id="output">
                                    <?php
                                        if (mysqli_num_rows($users_list_log) > 0) {
                                            $count = 1;
                                            while($row_user_log = mysqli_fetch_array($users_list_log)) {
                                    ?>
                                                <tr>
                                                    <td><input type="checkbox" class="checkItem" value="<?= $row_user_log["id"];?>" name="file_id[]" 
                                                    <?php 
                                                    if(empty($row_user_log["log_in"]) || empty($row_user_log["log_out"])){
                                                        echo "disabled";
                                                    }
                                                    
                                                    ?>
                                                    ></td>
                                                    <td><img src="../profile/<?= $row_user_log["profile"];?>" class="shadow rounded-circle" alt="profile" height="50px" width="50px"></td>
                                                    <td><?= $row_user_log["idnum"];?></td>
                                                    <td><?= $row_user_log["role"];?></td>
                                                    <td><?= $row_user_log["firstname"] . " " . $row_user_log["lastname"];?></td>
                                                    <td><span class="badge badge-sm bg-gradient-success"><?php if(isset($row_user_log["log_in"])){echo date("F j, Y, g:i a", strtotime($row_user_log["log_in"]));}  ?></span></td>
                                                    <td><span class="badge badge-sm bg-gradient-danger"><?php if(isset($row_user_log["log_out"])){echo date("F j, Y, g:i a", strtotime($row_user_log["log_out"]));}  ?></span></td>
                                                </tr>
                                    <?php
                                            $count++;
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
            url:"log_search.php",
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
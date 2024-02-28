<?php 
    $title = "Archive";
    include_once 'header.php';
    $_SESSION['backpage'] = "admin_arc.php";
    $_SESSION['viewed'] = null;

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

    $filter="all";
    $category="all";

    if(isset($_GET['status_filter']) && $_GET['status_filter'] != "all"){
        $filter = $_GET['status_filter'];

        $result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM research_documents WHERE status='$filter' 
        AND status<>'Published' AND instatus='inactive'");
        $total_records = mysqli_fetch_array($result_count);
        $total_records = $total_records['total_records'];
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1;

        $files_list = "SELECT research_documents.*, users.firstname, users.lastname, degree_strand.ds_code
        FROM research_documents,users,degree_strand
        WHERE research_documents.status='$filter' AND research_documents.status<>'Published' AND research_documents.instatus='inactive'
        AND (research_documents.adviser=users.id AND research_documents.degree_strand=degree_strand.id)
        ORDER BY research_documents.date_submitted DESC
        LIMIT $offset, $total_records_per_page";
        
        $files_list_result = mysqli_query($conn, $files_list);
    }
    elseif(isset($_GET['category']) && $_GET['category'] != "all"){
        $category = $_GET['category'];

        $result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM research_documents,users WHERE users.role='$category' 
        AND research_documents.status<>'Published' AND research_documents.instatus='inactive' AND research_documents.submitted_by=users.id");
        $total_records = mysqli_fetch_array($result_count);
        $total_records = $total_records['total_records'];
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1;

        $files_list = "SELECT research_documents.*, users.firstname, users.lastname, degree_strand.ds_code
        FROM research_documents,users,degree_strand
        WHERE users.role='$category' AND research_documents.status<>'Published' AND research_documents.instatus='inactive'
        AND (research_documents.submitted_by=users.id AND research_documents.degree_strand=degree_strand.id)
        ORDER BY research_documents.date_submitted DESC
        LIMIT $offset, $total_records_per_page";

        $files_list_result = mysqli_query($conn, $files_list);
    }
    else{
        $filter="all";
        $category="all";

        $result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM research_documents,users WHERE research_documents.status<>'Published' 
        AND research_documents.instatus='inactive' AND research_documents.adviser=users.id");
        $total_records = mysqli_fetch_array($result_count);
        $total_records = $total_records['total_records'];
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1;

        $files_list = "SELECT research_documents.*, users.firstname, users.lastname, degree_strand.ds_code
        FROM research_documents,users,degree_strand
        WHERE research_documents.status<>'Published' AND research_documents.instatus='inactive' AND (research_documents.adviser=users.id AND research_documents.degree_strand=degree_strand.id)
        ORDER BY research_documents.date_submitted DESC
        LIMIT $offset, $total_records_per_page";

        $files_list_result = mysqli_query($conn, $files_list);

    }
    if(isset($_POST['submit'])){
        if(isset($_POST['file_id'])){
            foreach($_POST['file_id'] as $file_id){

                $sql_comments_file = mysqli_query($conn,"DELETE FROM comments WHERE document='$file_id'");
                $sql_actions_file = mysqli_query($conn,"DELETE FROM action_done WHERE document='$file_id'");

                $sql_get_file = mysqli_query($conn,"SELECT * FROM research_documents WHERE id='$file_id'");
                $row_get_file  = mysqli_fetch_assoc($sql_get_file);
                $get_file_name = $row_get_file['file_names'];
                $get_file_status = $row_get_file['status'];

                if($get_file_status != "Published"){
                    unlink("../documents/".$get_file_name);
                }

                $sql_delete_file = mysqli_query($conn,"DELETE FROM research_documents WHERE id='$file_id'");
            }
            $activity = "Deletes a research documents permanently";
            $activity_log_sql = mysqli_query($conn,"INSERT INTO activity_log (account, activity, created_at) VALUES ('$adviser', '$activity', now())");
            echo "<script>swal({title: 'File Deleted', text: 'Deleting a file successfully done!', icon: 
                'success'}).then(function(){ 
                    window.location.href = 'admin_arc.php';
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
                        <h4 style="overflow-x: auto;" class="text-primary">Archive</h4>
    
                        
                        <div class="row mt-4" style="overflow-x: auto;">
                            <div class="col-lg-12">

                                <div class="form-group" style="float: left; margin-right: 1rem;">
                                    <input class="form-control form-control-alternative" placeholder="Search" id=search type="text" style="width: 15rem;">
                                </div>
                                
                                <form method="GET" style="float: left; margin-right: 1rem;">
                                    <div class="form-group">
                                        <select class="form-control form-control-alternative" name="category" onchange="this.form.submit()" style="width: 7rem;">
                                            <option value="all" <?php if(isset($_GET['category']) && $_GET['category'] == "all"){ echo "selected";} ?>>Select Class</option>
                                            <option value="Graduates" <?php if (isset($_GET['category']) && $_GET['category'] == "Graduates"){ echo "selected";} ?>>Graduates</option>
                                            <option value="Faculty" <?php if(isset($_GET['category']) && $_GET['category'] == "Faculty"){ echo "selected";} ?>>Faculty</option>
                                            <option value="College" <?php if(isset($_GET['category']) && $_GET['category'] == "College"){ echo "selected";} ?>>College</option>
                                            <option value="Senior High School" <?php if(isset($_GET['category']) && $_GET['category'] == "Senior High School"){ echo "selected";} ?>>Senior High</option>
                                        </select>  
                                    </div>  
                                </form>

                                <form method="GET" style="float: left;">
                                    <div class="form-group">
                                        <select class="form-control form-control-alternative" name="status_filter" onchange="this.form.submit()" style="width: 7rem;">
                                            <option value="all" <?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == "all"){ echo "selected";} ?>>Select Status</option>
                                            <option value="Pending" <?php if (isset($_GET['status_filter']) && $_GET['status_filter'] == "Pending"){ echo "selected";} ?>>Pending</option>
                                            <option value="Approved" <?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == "Approved"){ echo "selected";} ?>>Approved</option>
                                            <option value="Revision" <?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == "Revision"){ echo "selected";} ?>>Revision</option>
                                            <option value="Rejected" <?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == "Rejected"){ echo "selected";} ?>>Rejected</option>
                                        </select>  
                                    </div>  
                                </form>

                                <form action="admin_arc.php" method="POST">
                                    <div class="btn-group" role="group" style="float: right;">
                                        <button type="submit" name="submit" class="btn btn-dark"  onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash"></i> Delete</button>
                                    </div>
                                    
                                <table id="table">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkAll"></th>
                                        <th>Research Title</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Chapter</th>
                                        <th>Version</th>
                                        <th>Date Submitted</th>
                                        <th>Degree/Strand</th>
                                        <th>Adviser</th>
                                    </tr>
                                    </thead>
                                    <tbody id="output">
                                    <?php
                                        if (mysqli_num_rows($files_list_result) > 0) {
                                            while($row_files_list = mysqli_fetch_array($files_list_result)) {
                                    ?>
                                        <tr>
                                            <td><input type="checkbox" class="checkItem" value="<?= $row_files_list["id"];?>" name="file_id[]"></td>
                                            <td>
                                            <a href="view_file.php?fileid=<?= $row_files_list["id"];?>" class="text-primary"><?= $row_files_list["research_title"];?></a>
                                            <br><small><?= $row_files_list["authors"];?>
                                                <br>
                                                    <i class="fa fa-eye text-info"></i> 
                                                    <?php
                                                        $viewid = $row_files_list["id"];
                                                        $view = mysqli_query($conn,
                                                        "SELECT * FROM action_done WHERE document='$viewid' AND type='view'");
                                                        $view_rows = mysqli_num_rows($view);

                                                        if(!empty($view_rows)){ echo $view_rows; } else{ echo 0;}
                                                    ?>
                                                    <i class="fa fa-download text-danger"></i> 
                                                    <?php
                                                        $downloadid = $row_files_list["id"];
                                                        $download = mysqli_query($conn,
                                                        "SELECT * FROM action_done WHERE document='$downloadid' AND type='download'");
                                                        $download_rows = mysqli_num_rows($download);

                                                        if(!empty($download_rows)){ echo $download_rows; } else{ echo 0;}
                                                    ?>
                                                    <i class="fa fa-comment text-warning"></i> 
                                                    <?php
                                                        $commentid = $row_files_list["id"];
                                                        $comment = mysqli_query($conn,
                                                        "SELECT * FROM comments WHERE document='$commentid'");
                                                        $comment_rows = mysqli_num_rows($comment);

                                                        if(!empty($comment_rows)){ echo $comment_rows; } else{ echo 0;}
                                                    ?>
                                                </small>
                                            </td>
                                            <td><?= $row_files_list["type_r"];?></td>
                                            <td><span class="badge badge-sm bg-gradient-<?php 
                                                if($row_files_list["status"] == "Pending"){
                                                    echo "primary";
                                                }
                                                elseif($row_files_list["status"] == "Approved"){
                                                    echo "success";
                                                }
                                                elseif($row_files_list["status"] == "Revision"){
                                                    echo "warning";
                                                }
                                                else{
                                                    echo "danger";
                                                }
                                            ?>"><?= $row_files_list["status"];?></span></td>
                                            <td><span class="badge badge-sm bg-gradient-secondary"><?= $row_files_list["chapter"];?></span></td>
                                            <td><span class="badge badge-sm bg-gradient-secondary"><?= $row_files_list["version"];?></span></td>
                                            <td><?php echo date("F j, Y, g:i a", strtotime($row_files_list["date_submitted"])); ?></td>
                                            <td><?= $row_files_list["ds_code"];?></td>
                                            <td>
                                                <?php 

                                                    if(isset($_GET['category']) && $_GET['category'] != "all"){
                                                        $ad = $row_files_list["adviser"];
                                                        $result_ad = mysqli_query($conn,"SELECT research_documents.*, users.firstname, users.lastname
                                                        FROM research_documents,users
                                                        WHERE research_documents.adviser='$ad' AND research_documents.adviser=users.id");
                                                        $row_ad  = mysqli_fetch_assoc($result_ad);

                                                        echo $row_ad["firstname"] . " " . $row_ad["lastname"]; 
                                                    }
                                                    else{
                                                        echo $row_files_list["firstname"] . " " . $row_files_list["lastname"];
                                                    } 
                                                    
                                                ?>
                                        
                                            </td>
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
                                <?php if($page_no > 1){ echo "<li class='page-item'><a class='page-link'  href='?page_no=1&&status_filter=$filter&&category=$category'><i class='fa fa-angle-double-left'></i></a></li>"; } ?>
    
                                    <li class="page-item" <?php if($page_no <= 1){ echo "class='page-item disabled'"; } ?>>
                                    <a class="page-link" <?php if($page_no > 1){ echo "href='?page_no=$previous_page&&status_filter=$filter&&category=$category'"; } ?>><i class="fa fa-angle-left"></i></a>
                                    </li>
                                    
                                    <?php 
                                        if ($total_no_of_pages <= 10){  	 
                                            for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                                                if ($counter == $page_no) {
                                                    echo "<li class='page-item active'><a class='page-link' style='color: white;'>$counter</a></li>";	
                                                }
                                                else{
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&&status_filter=$filter&&category=$category'>$counter</a></li>";
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
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&&status_filter=$filter&&category=$category'>$counter</a></li>";
                                                    }
                                                }
                                                echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last&&status_filter=$filter&&category=$category'>$second_last</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages&&status_filter=$filter&&category=$category'>$total_no_of_pages</a></li>";
                                            }

                                            elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=1&&status_filter=$filter&&category=$category'>1</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=2&&status_filter=$filter&&category=$category'>2</a></li>";
                                                echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                                for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
                                                    if ($counter == $page_no) {
                                                        echo "<li class='page-item active'><a class='page-link' style='color: white;'>$counter</a></li>";	
                                                    }
                                                    else{
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&&status_filter=$filter&&category=$category'>$counter</a></li>";
                                                    }                  
                                                }
                                                echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last&&status_filter=$filter&&category=$category'>$second_last</a></li>";
                                                echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages&&status_filter=$filter&&category=$category'>$total_no_of_pages</a></li>";      
                                            }
                                            
                                            else {
                                            echo "<li class='page-item'><a class='page-link' href='?page_no=1&&status_filter=$filter&&category=$category'>1</a></li>";
                                            echo "<li class='page-item'><a class='page-link' href='?page_no=2&&status_filter=$filter&&category=$category'>2</a></li>";
                                            echo "<li class='page-item'><a class='page-link'>...</a></li>";

                                                for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                                    if ($counter == $page_no) {
                                                        echo "<li class='page-item active'><a class='page-link' style='color: white;'>$counter</a></li>";	
                                                    }
                                                    else{
                                                        echo "<li class='page-item'><a class='page-link' href='?page_no=$counter&&status_filter=$filter&&category=$category'>$counter</a></li>";
                                                    }                   
                                                }
                                            }
                                        }
                                    ?>
                                    
                                    <li class='page-item' <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
                                    <a class='page-link' <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page&&status_filter=$filter&&category=$category'"; } ?>><i class="fa fa-angle-right"></i></a>
                                    </li>
                                    <?php if($page_no < $total_no_of_pages){
                                            echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages&&status_filter=$filter&&category=$category'><i class='fa fa-angle-double-right'></i></a></li>";
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
                $(".checkItem").prop('checked',true);
            }
            else{
                $(".checkItem").prop('checked',false);
            }
        });

        $("#search").keyup(function(){

        var input = $("#search").val();
        $.ajax({
            url:"searcharc.php",
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
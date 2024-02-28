<?php
    $title = "Journal";
    include_once 'header.php';

    $_SESSION['pub_viewed'] = null;

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

        $result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records 
        FROM published_research,research_documents,users 
        WHERE users.role='$filter' AND research_documents.status='Published' AND published_research.document=research_documents.id AND research_documents.submitted_by=users.id");
        $total_records = mysqli_fetch_array($result_count);
        $total_records = $total_records['total_records'];
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1;

        $files_list = "SELECT published_research.*,research_documents.*,users.role
        FROM published_research,research_documents,users
        WHERE users.role='$filter' AND research_documents.status='Published' AND published_research.document=research_documents.id AND research_documents.submitted_by=users.id
        ORDER BY published_research.id DESC
        LIMIT $offset, $total_records_per_page";

        $files_list_result = mysqli_query($conn, $files_list);

    }
    else{
        $filter="all";

        $result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM published_research");
        $total_records = mysqli_fetch_array($result_count);
        $total_records = $total_records['total_records'];
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1;

        $files_list = "SELECT published_research.*,research_documents.*
        FROM published_research,research_documents
        WHERE published_research.document=research_documents.id
        ORDER BY published_research.id DESC
        LIMIT $offset, $total_records_per_page";

        $files_list_result = mysqli_query($conn, $files_list);
    }

?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 style="overflow-x: auto;" class="text-primary">Completed Research</h4>

                        <div class="row mt-4" style="overflow-x: auto;">
                            <div class="col-lg-12">

                                <div class="form-group" style="float: left; margin-right: 1rem;">
                                    <input class="form-control form-control-alternative" placeholder="Search" id=search type="text" style="width: 15rem;">
                                </div>  

                                <form method="GET" style="float: left;">
                                    <div class="form-group">
                                        <select class="form-control form-control-alternative" name="status_filter" onchange="this.form.submit()" style="width: 7rem;">
                                            <option value="all" <?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == "all"){ echo "selected";} ?>>Select Class</option>                      
                                            <option value="Graduates" <?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == "Graduates"){ echo "selected";} ?>>Graduates</option>
                                            <option value="Faculty" <?php if (isset($_GET['status_filter']) && $_GET['status_filter'] == "Faculty"){ echo "selected";} ?>>Faculty</option>
                                            <option value="College" <?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == "College"){ echo "selected";} ?>>College</option>
                                            <option value="Senior High School" <?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == "Senior High School"){ echo "selected";} ?>>Senior High</option>
                                        </select>  
                                    </div>  
                                </form>

                                <div class="btn-group" role="group" style="float: right;">
                                    <a href="publish_research.php" style="float: right; overflow-x: auto;" class="btn btn-outline-dark btn-round"><i class="fas fa-book"></i> Publish Research</a>
                                </div>
                                
                                <table id="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Research Title</th>
                                        <th>Adviser/s</th>
                                        <th>Format</th>
                                        <th>Degree/Strand</th>
                                        <th>Department</th>
                                        <th>Year</th>
                                    </tr>
                                    </thead>
                                    <tbody id="output">
                                    <?php
                                        if (mysqli_num_rows($files_list_result) > 0) {
                                            $count = 1;
                                            while($row_files_list = mysqli_fetch_array($files_list_result)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $count; ?></td>
                                            <td>
                                            <a href="view_published_research.php?fileid=<?= $row_files_list["id"];?>" class="text-primary"><?= $row_files_list["research_title"];?></a>
                                            <br><small><?= $row_files_list["authors"];?>
                                                <i class="fa fa-eye text-info"></i>
                                                <?php
                                                    $getid = $row_files_list["id"];

                                                    $publish = mysqli_query($conn,"SELECT id FROM published_research WHERE document='$getid'");
                                                    $row_publish  = mysqli_fetch_assoc($publish);
                                            
                                                    $viewid = $row_publish['id'];
                                                    
                                                    $view = mysqli_query($conn,
                                                    "SELECT * FROM publish_viewed WHERE published='$viewid'");
                                                    $view_rows = mysqli_num_rows($view);

                                                    if(!empty($view_rows)){ echo $view_rows; } else{ echo 0;}
                                                ?>
                                                </small>
                                            </td>
                                            <td>
                                                <?php 
                                                   
                                                    $ad = $row_files_list["adviser"];
                                                    $result_ad = mysqli_query($conn,"SELECT research_documents.*, users.firstname, users.lastname
                                                    FROM research_documents,users
                                                    WHERE research_documents.adviser='$ad' AND research_documents.adviser=users.id");
                                                    $row_ad  = mysqli_fetch_assoc($result_ad);

                                                    echo $row_ad["firstname"] . " " . $row_ad["lastname"]; 
                                                                                                       
                                                ?>
                                            </td>
                                            <td><?= strtoupper($row_files_list["format"])?></td>
                                            <td>
                                                <?php 
                                                   
                                                   $degree = $row_files_list["degree_strand"];
                                                   $result_degree = mysqli_query($conn,"SELECT research_documents.*, degree_strand.ds_code
                                                   FROM research_documents,degree_strand
                                                   WHERE research_documents.degree_strand='$degree' AND research_documents.degree_strand=degree_strand.id");
                                                   $row_degree  = mysqli_fetch_assoc($result_degree);

                                                   echo $row_degree["ds_code"]; 
                                                                                                      
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                   
                                                   $dept = $row_files_list["department"];
                                                   $result_dept = mysqli_query($conn,"SELECT research_documents.*, department.dept_code
                                                   FROM research_documents,department
                                                   WHERE research_documents.department='$dept' AND research_documents.department=department.id");
                                                   $row_dept  = mysqli_fetch_assoc($result_dept);

                                                   echo $row_dept["dept_code"]; 
                                                                                                      
                                                ?>
                                            </td>
                                            <td><?= $row_files_list["year"];?></td></td>
                                        </tr>
                                    <?php
                                            $count++;
                                            }
                                        }
                                    ?>
                                    </tbody>
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

        $("#search").keyup(function(){

        var input = $("#search").val();
        $.ajax({
            url:"searchjournal.php",
            method:"POST",
            data:{input:input},
                success:function(data){
                    $("#output").html(data);
                }
            })
        });
    })
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>
</html>
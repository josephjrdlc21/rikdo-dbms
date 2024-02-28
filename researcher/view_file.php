<?php 
    $title = "View File";
    include_once 'header.php';

    if(isset($_GET['fileid'])){
        $fileid = $_GET['fileid'];

        $result_edit_file = mysqli_query($conn,"SELECT * FROM research_documents WHERE id='$fileid'");
        $row_edit_file  = mysqli_fetch_assoc($result_edit_file);

        $id = $row_edit_file ['id'];
        $title = $row_edit_file ['research_title'];
        $authors = $row_edit_file ['authors'];
        $degree = $row_edit_file ['degree_strand'];
        $department = $row_edit_file ['department'];
        $chapter = $row_edit_file ['chapter'];
        $version = $row_edit_file ['version'];
        $status = $row_edit_file ['status'];
        $date_submitted = $row_edit_file ['date_submitted'];
        $submitted_by = $row_edit_file ['submitted_by'];
        $adviser = $row_edit_file ['adviser'];
        $filename = $row_edit_file ['file_names'];

        if(!empty($id) && !isset($_SESSION['viewed'])){
            $views = mysqli_query($conn,"INSERT INTO action_done (document, type) VALUES ('$id', 'view')");
            if($views){
                $_SESSION['viewed'] = true;
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
                        <h4 class="card-title text-primary">Research Detail</h4>

                        <div class="row mt-4" style="overflow-x: auto;">

                            <div class="col-sm-12 col-md-12 col-lg-12" >
                                <div class="shadow-lg card card-plain mb-4">
                                    <div class="card-body">
                                    <form method="POST">
                                        
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <div class='btn-group d-flex' role='group' style='overflow: auto;'>
                                                
                                                    <a href="research.php" class="btn btn-light"><i class="fas fa-reply"></i> Back</a>
                                                    <a href="download.php?files=<?php echo $filename?>&&id=<?php echo $fileid?>" class="btn btn-light"><i class="fa fa-download"></i> Download to open</a>
                                                    <a href="comments.php?fileid=<?php echo $fileid; ?>" class="btn btn-light"><i class="fa fa-comment"></i> Comment</a>
                                                    <a  href="version.php?fileid=<?php echo $fileid; ?>" class="btn btn-light"><i class="fa fa-file"></i> Version</a>
                                                    <a href="chapter.php?fileid=<?php echo $fileid; ?>" class="btn btn-light"><i class="fa fa-location-arrow"></i> Chapter</a>
                                                
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label style="font-size: 15px;">Research Title</label>
                                                <textarea class="form-control form-control-alternative" rows="3" disabled><?php echo $title ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label style="font-size: 15px;">Authors</label>
                                                <textarea class="form-control form-control-alternative" rows="2" disabled><?php echo $authors ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-sm-6">
                                                <label style="font-size: 15px;">Degree/Strand</label>
                                                <select class="form-control form-control-alternative" disabled>
                                                <?php 
                                                    $sql_select_degree = mysqli_query($conn,"SELECT * FROM degree_strand WHERE id='$degree'");
                                                    if (mysqli_num_rows($sql_select_degree) > 0) {
                                                        while($row_select_degree = mysqli_fetch_assoc($sql_select_degree)) {
                                                ?>
                                                    <option value="<?= $row_select_degree["id"];?>" <?php if($degree == $row_select_degree["id"]){ echo 'selected';}?>><?= $row_select_degree["ds_name"];?></option>
                                                <?php 
                                                        }
                                                    }
                                                ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label style="font-size: 15px;">Department</label>
                                                <select class="form-control form-control-alternative" disabled>
                                                <?php 
                                                    $sql_select_dept = mysqli_query($conn,"SELECT * FROM department WHERE id='$department'");
                                                    if (mysqli_num_rows($sql_select_dept) > 0) {
                                                        while($row_select_dept = mysqli_fetch_assoc($sql_select_dept)) {
                                                ?>
                                                    <option value="<?= $row_select_dept["id"];?>" <?php if($department == $row_select_dept["id"]){ echo 'selected';}?>><?= $row_select_dept["dept_name"];?></option>
                                                <?php 
                                                        }
                                                    }
                                                ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-sm-4">
                                                <label style="font-size: 15px;">Chapter</label>
                                                <select class="form-control form-control-alternative" disabled>
                                                    <option><?php echo $chapter;?></option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label style="font-size: 15px;">Version</label>
                                                <select class="form-control form-control-alternative" disabled>
                                                    <option><?php echo $version;?></option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label style="font-size: 15px;">Status</label>
                                                <select class="form-control form-control-alternative" disabled>
                                                    <option value="Pending" <?php if($status == "Pending"){ echo 'selected';}?>>Pending</option>
                                                    <option value="Approved" <?php if($status == "Approved"){ echo 'selected';}?>>Approved</option>
                                                    <option value="Revision" <?php if($status == "Revision"){ echo 'selected';}?>>Revision</option>
                                                    <option value="Rejected" <?php if($status == "Rejected"){ echo 'selected';}?>>Rejected</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-sm-4">
                                                <label style="font-size: 15px;">Date Submitted</label>
                                                <input type="text" class="form-control form-control-alternative" value="<?php echo date("F j, Y, g:i a", strtotime($date_submitted)); ?>" disabled >
                                            </div>
                                            <div class="col-sm-4">
                                                <label style="font-size: 15px;">Submitted by</label>
                                                <?php 
                                                    $result_submitted_by = mysqli_query($conn,"SELECT * FROM users WHERE id='$submitted_by'");
                                                    $row_submitted_by  = mysqli_fetch_assoc($result_submitted_by);

                                                    $researcher_name = $row_submitted_by['firstname'] . " " . $row_submitted_by['lastname'];
                                                
                                                ?>
                                                <input type="text" class="form-control form-control-alternative" value="<?php echo $researcher_name ?>" disabled >
                                            </div>
                                            <div class="col-sm-4">
                                                <label style="font-size: 15px;">Adviser</label>
                                                <?php 
                                                    $result_adviser = mysqli_query($conn,"SELECT * FROM users WHERE id='$adviser'");
                                                    $row_adviser  = mysqli_fetch_assoc($result_adviser);

                                                    $adviser_name = $row_adviser['firstname'] . " " . $row_adviser['lastname'];
                                                
                                                ?>
                                                <input type="text" class="form-control form-control-alternative" value="<?php echo $adviser_name?>" disabled >
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
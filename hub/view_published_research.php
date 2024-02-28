<?php 
    $title = "Published Research";
    require_once "db.php";
    include_once 'header.php';

    if(isset($_GET['fileid'])){
        $fileid = $_GET['fileid'];

        $result_view_file = mysqli_query($conn,"SELECT published_research.*,research_documents.*
        FROM published_research,research_documents
        WHERE published_research.document=research_documents.id AND published_research.document='$fileid'");
        $row_view_file  = mysqli_fetch_assoc($result_view_file);

        $reseach = $row_view_file['research_title'];
        $abstract = $row_view_file['abstract'];
        $authors = $row_view_file['authors'];
        $format = $row_view_file['format'];
        $year = $row_view_file['year'];
        $adviser = $row_view_file['adviser'];
        $degree = $row_view_file['degree_strand'];
        $department = $row_view_file['department'];
        $filename = $row_view_file['file_names'];

        $publish = mysqli_query($conn,"SELECT id FROM published_research WHERE document='$fileid'");
        $row_publish  = mysqli_fetch_assoc($publish);

        $pub_id = $row_publish['id'];

        if(!empty($pub_id) && !isset($_SESSION['pub_vieweds'])){
            $views = mysqli_query($conn,"INSERT INTO publish_viewed (published) VALUES ('$pub_id')");
            if($views){
                $_SESSION['pub_vieweds'] = true;
            }
        }
        
    }   
?>
<main class="main-content mt-0">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11" style="background-image: url('../image/schoolg2.jpg'); background-position: top;">
      <span class="mask bg-gradient-secondary opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Research Details</h1>
            <p class="text-lead text-white">Research, Innovation, and Knowledge Development Office</p>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
        <div class="row mt-lg-n12 mt-md-n11 mt-n10">
            <div class="col-xl-12 col-lg-12 col-md-12 mx-auto">
                <div class="card mt-4">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12" >
                                <div class="shadow-lg card card-plain mb-4">
                                    <div class="card-body">

                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <div class='btn-group d-flex' role='group' style='overflow: auto;'>
                                                
                                                    <a href="
                                                    <?php
                                                        if(isset($_SESSION['backpage_hub'])){
                                                            $backpage = $_SESSION['backpage_hub'];
                                                            if($backpage == "faculty.php"){
                                                                echo $backpage;
                                                            }
                                                            if($backpage == "college.php"){
                                                                echo $backpage;
                                                            }
                                                            if($backpage == "graduates.php"){
                                                                echo $backpage;
                                                            }
                                                            if($backpage == "shs.php"){
                                                                echo $backpage;
                                                            }
                                                        }

                                                    ?>
                                                    " class="btn btn-light"><i class="fas fa-reply"></i> Click to Return</a>
                                                    <a href="open.php?fileid=<?php echo $fileid; ?>" class="btn btn-light"><i class="fas fa-file"></i> Open Document</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label style="font-size: 15px;">Title</label>
                                                <textarea class="form-control form-control-alternative" rows="3" disabled><?php echo $reseach; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label style="font-size: 15px;">Abstract</label>
                                                <textarea class="form-control form-control-alternative" rows="5" disabled><?php echo $abstract; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label style="font-size: 15px;">Authors</label>
                                                <textarea class="form-control form-control-alternative" rows="2" disabled><?php echo $authors; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label style="font-size: 15px;">Adviser</label>
                                                <input type="text" class="form-control form-control-alternative" value="<?php  
                                                    $result_ad = mysqli_query($conn,"SELECT research_documents.*, users.firstname, users.lastname
                                                    FROM research_documents,users
                                                    WHERE research_documents.adviser='$adviser' AND research_documents.adviser=users.id");
                                                    $row_ad  = mysqli_fetch_assoc($result_ad);
                                                    echo $row_ad["firstname"] . " " . $row_ad["lastname"]; ?>" disabled >
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-sm-6">
                                                <label style="font-size: 15px;">Degree/Strand</label>
                                                <input type="text" class="form-control form-control-alternative" value="<?php  
                                                    $result_degree = mysqli_query($conn,"SELECT research_documents.*, degree_strand.ds_code
                                                    FROM research_documents,degree_strand
                                                    WHERE research_documents.degree_strand='$degree' AND research_documents.degree_strand=degree_strand.id");
                                                    $row_degree  = mysqli_fetch_assoc($result_degree);
                                                    echo $row_degree["ds_code"]; ?>" disabled >
                                            </div>
                                            <div class="col-sm-6">
                                                <label style="font-size: 15px;">Department</label>
                                                <input type="text" class="form-control form-control-alternative" value="<?php  
                                                    $result_dept = mysqli_query($conn,"SELECT research_documents.*, department.dept_code
                                                    FROM research_documents,department
                                                    WHERE research_documents.department='$department' AND research_documents.department=department.id");
                                                    $row_dept  = mysqli_fetch_assoc($result_dept);
                                                    echo $row_dept["dept_code"]; ?>" disabled >
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-sm-6">
                                                <label style="font-size: 15px;">Year</label>
                                                <input type="text" class="form-control form-control-alternative" value="<?php echo $year; ?>" disabled >
                                            </div>
                                            <div class="col-sm-6">
                                                <label style="font-size: 15px;">Format</label>
                                                <input type="text" class="form-control form-control-alternative" value="<?php echo strtoupper($format); ?>" disabled >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </main><br><br>
  <?php 
  include 'footer.php';
?>
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
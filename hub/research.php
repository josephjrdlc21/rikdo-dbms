<?php 
    $title = "Research Articles";
    require_once "db.php";
    include_once 'header.php';

    $_SESSION['pub_viewed'] = null;

    $files_list = "SELECT published_research.*,research_documents.*
    FROM published_research,research_documents
    WHERE published_research.document=research_documents.id ORDER BY research_documents.id ASC";

    $files_list_result = mysqli_query($conn, $files_list);

    if(isset($_GET['fileid'])){

      $file = $_GET['fileid'];

    }
    else{
      $sql_top1 = mysqli_query($conn,"SELECT document FROM published_research LIMIT 1");
      $row_top1 = mysqli_fetch_assoc($sql_top1);

      if($row_top1 ){
        $file = $row_top1["document"];
      }
    }
?>
<main class="main-content mt-0">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11" style="background-image: url('../image/sign.png'); background-position: top;">
      <span class="mask bg-gradient-secondary opacity-4"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Published Research Articles</h1>
            <p class="text-lead text-white">Research, Innovation, and Knowledge Development Office</p>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
        <div class="row mt-lg-n12 mt-md-n11 mt-n10">
            <div class="col-xl-12 col-lg-12 col-md-12 mx-auto">
                <div class="card mt-6">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4">
                                <div class="card card-plain">
                                    <div class="card-body" id="article-contents">
                                        <h5>Article Contents</h5><br>
                                        <?php
                                        if (mysqli_num_rows($files_list_result) > 0) {
                                          while($row_files_list = mysqli_fetch_array($files_list_result)) {
                                        ?>
                
                                          <div style="font-size: 16px;">   
                                              <a href="research.php?fileid=<?= $row_files_list["id"];?>" class="text-primary animate-con" <?php  
                                              if($file == $row_files_list["id"]){ echo "style='background-color: #ccffff;'"; }?>><?= $row_files_list["research_title"];?></a>
                                          </div><br> 
                                        <?php
                                          }
                                        }
                                        ?> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-8">
                                <div class="card card-plain">
                                    <div class="card-body">
                                        <?php
                                          if(!empty($file)){
                                            $result_of_research = mysqli_query($conn,"SELECT published_research.*,research_documents.*
                                            FROM published_research,research_documents
                                            WHERE published_research.document=research_documents.id AND published_research.document='$file'");
                                            $row_research  = mysqli_fetch_assoc($result_of_research);

                                            $reseach = $row_research['research_title'];
                                            $abstract = $row_research['abstract'];
                                            $authors = $row_research['authors'];
                                            $format = $row_research['format'];
                                            $year = $row_research['year'];
                                            $filename = $row_research['file_names'];
                                            $idfile = $row_research['id'];

                                        ?> 
                                            <h5><?php echo $reseach; ?></h5><br>

                                            <p class="font-italic">Authors: <?php echo $authors; ?>
                                            <br>Year: <?php echo $year; ?>
                                            </p>

                                            <br><h5>Abstract:</h5><br>

                                            <p class="text-justify"><?php echo $abstract; ?></p><br>

                                            <a href="open.php?fileid=<?php echo $idfile; ?>" class="btn btn-info w-100"><i class="fas fa-file"></i> Open Document</a>
                                        <?php
                                          }
                                        ?>                                                
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
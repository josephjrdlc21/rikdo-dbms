<?php 
    $title = "Publish Research";
    use Dompdf\Dompdf;
    require_once '../word/vendor/autoload.php';
    require_once '../dompdf/vendor/autoload.php';

    include_once 'header.php';

    $adviser = $_SESSION['idaccount_admin'];

    if(isset($_POST['submit'])){

        $research = $_POST['research'];
        $abstract = $_POST['abstract'];
        $format = $_POST['format'];

        $research_file = mysqli_query($conn,"SELECT * FROM research_documents WHERE id='$research'");
        $row_research_file = mysqli_fetch_assoc($research_file);

        $name_file = $row_research_file['file_names'];
        $title = $row_research_file['research_title'];

        if($research_file){
            $wordFilePath = "../documents/" . $name_file;

            $fileNameWithoutExtension = pathinfo($wordFilePath, PATHINFO_FILENAME);
            $newExtension = 'pdf';
            $pdfFilePath = '../publish/' . $fileNameWithoutExtension . '.' . $newExtension;
            $newname = $fileNameWithoutExtension . '.' . $newExtension;

            $phpWord = \PhpOffice\PhpWord\IOFactory::load($wordFilePath);

            $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
            ob_start();
            $htmlWriter->save('php://output');
            $html = ob_get_clean();
            
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            
            $dompdf->render();
            file_put_contents($pdfFilePath, $dompdf->output());

            unlink($wordFilePath);

            $sql_publish_file = mysqli_query($conn,"INSERT INTO published_research (document, year, format, abstract) 
            VALUES ('$research', year(now()), '$format', '$abstract')");

            $activity = "Post completed research entitled " . $title;
            $activity_log_sql = mysqli_query($conn,"INSERT INTO activity_log (account, activity, created_at) VALUES ('$adviser', '$activity', now())");

            if($sql_publish_file){
                $sql_updatefile_status = mysqli_query($conn,"UPDATE research_documents SET status='Published', file_names='$newname' WHERE id='$research'");

                if($sql_updatefile_status){
                    echo "<script>swal('Research Posted', 'This research has been posted successfully!', 'success');</script>";
                }
            }
            else{
                echo "<script>swal('Failed!', 'Oops Something Went Wrong!', 'error');</script>";
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
                        <h4 class="card-title text-primary">Completed Research</h4>

                        <div class="row mt-4" style="overflow-x: auto;">

                            <div class="col-sm-12 col-md-12 col-lg-12" >
                                <div class="shadow-lg card card-plain mb-4">
                                    <div class="card-body">
                                        <form method="POST">
                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <label style="font-size: 15px;">Select Research to post <span style="color: red;">*</span> </label>
                                                    <select class="form-control form-control-alternative" name="research" required>
                                                        <option style="display: none;" selected></option>
                                                        <?php 
                                                            $sql_select_research = mysqli_query($conn,"SELECT DISTINCT * FROM research_documents WHERE status='Approved' AND chapter>=5 AND instatus<>'inactive'");
                                                            if (mysqli_num_rows($sql_select_research) > 0) {
                                                                while($row_select_research = mysqli_fetch_assoc($sql_select_research)) {
                                                        ?>
                                                            <option value="<?= $row_select_research["id"];?>"><?= $row_select_research["research_title"] . " by: " . $row_select_research["authors"];?></option>
                                                        <?php 
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <label style="font-size: 15px;">Research Abstract <span style="color: red;">*</span> </label>
                                                    <textarea class="form-control form-control-alternative" rows="4" name="abstract" required></textarea>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <label style="font-size: 15px;">Type of Format Used <span style="color: red;">*</span> </label>
                                                    <select class="form-control form-control-alternative" name="format" required>
                                                        <option style="display: none;" selected></option>
                                                        <option value="Standard">Standard</option>
                                                        <option value="imrad">IMRAD</option>
                                                    </select>
                                                </div>
                                            </div>

                                            
                                            <a href="admin_journal.php" class="btn btn-light w-100 mt-2"><i class="fas fa-reply"></i> Back</a>
                                            <button type="submit" name="submit" class="btn btn-dark w-100"  onclick="return confirm('Are you sure you want to publish this research?')"><i class="fa fa-upload"></i> Post Research</button>     
                                        </div>
                                    </form>
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
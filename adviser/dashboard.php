<?php 
  $title = "dashboard";
  include_once 'header.php';

  $adviserid = $_SESSION['idaccount_adviser'];

  $total_research_check = mysqli_query($conn,
  "SELECT * FROM research_documents WHERE adviser='$adviserid' AND instatus='active' AND (status='Approved' OR status='Revision' OR status='Rejected' OR status='Pending')");
  $total_research_tocheck = mysqli_num_rows($total_research_check);

?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card animate-c">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Submitted Research</p>
                    <h5 class="font-weight-bolder">
                      <?php if(!empty($total_research_tocheck)) echo $total_research_tocheck; else{ echo "0";}?>
                    </h5>
                    <p class="mb-0">
                      <a href="archive.php" class="text-primary text-sm font-weight-bolder">View More <i class="fa fa-arrow-circle-right"></i></a>
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    <i class="ni ni-single-copy-04 text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-5">
      	<div class="col-lg-6 col-sm-6 mb-xl-0 mb-4">
          <div class="card card-size">
              <div class="card-header">
                  Submitted Files
              </div>
              <div class="card-body d-flex justify-content-center p-3">
              <canvas id="myChart2"></canvas>
                  <?php
                    $research_statuses = array('Pending', 'Approved', 'Revision', 'Rejected');
                    $statues_result = [];
                    foreach ($research_statuses as $research_status) {
                        $status_research = mysqli_query($conn,
                        "SELECT * FROM research_documents WHERE adviser='$adviserid' AND instatus='active' AND status='$research_status'");
                        $status_rows = mysqli_num_rows($status_research);
                     
                        if($research_status == "Pending"){
                            $statues_result[] = $status_rows;
                        }
                        if($research_status == "Approved"){
                            $statues_result[] = $status_rows;
                        }
                        if($research_status == "Revision"){
                            $statues_result[] = $status_rows;
                        }
                        if($research_status == "Rejected"){
                            $statues_result[] = $status_rows;
                        }
                    }
              
                  ?>
                 <script>
                      const ctx2 = document.getElementById('myChart2').getContext('2d');
                      const myChart2 = new Chart(ctx2, {
                          type: 'pie',
                          data: {
                              labels: ['Pending', 'Approved', 'Revisions', 'Rejected'],
                              datasets: [{
                                  label: 'Submitted Files',
                                  data: <?php if(!empty($statues_result)){echo json_encode($statues_result);} ?>,
                                  backgroundColor: [
                                  'rgb(255, 205, 86)',
                                  'rgb(60, 179, 113)',
                                  'rgba(255, 99, 71, 0.5)',
                                  'rgb(128,0,0)'
                                  ],
                                  hoverOffset: 2
                              }]
                          },
                          options:{
                              maintainAspectRatio: false,
                              plugins: {
                                labels: {
                                  render: 'value',
                                  precision: 0,
                                  showZero: true,
                                  fontSize: 20,
                                  fontColor: '#fff',
                                  fontStyle: 'normal',
                                  fontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                                  textShadow: true,
                                  shadowBlur: 10,
                                  shadowOffsetX: -5,
                                  shadowOffsetY: 5,
                                  shadowColor: 'rgba(255,0,0,0.75)',
                                  arc: true,
                                  position: 'default',
                                  overlap: true,
                                  showActualPercentages: true,
                                  images: [
                                    {
                                      src: 'image.png',
                                      width: 16,
                                      height: 16
                                    }
                                  ],
                                  outsidePadding: 4,
                                  textMargin: 4
                                }
                              }
                          }
                      });
                 </script>
                  
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
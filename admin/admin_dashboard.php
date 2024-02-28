<?php 
  $title = "Dashboard";
  include_once 'header.php';

  $total_research = mysqli_query($conn,
  "SELECT * FROM published_research");
  $total_research_articles = mysqli_num_rows($total_research);

  $total_research_check = mysqli_query($conn,
  "SELECT * FROM research_documents WHERE instatus='active' AND (status='Approved' OR status='Revision' OR status='Rejected' OR status='Pending')");
  $total_research_tocheck = mysqli_num_rows($total_research_check);

  $total_users = mysqli_query($conn,
  "SELECT * FROM users");
  $total_users_acc = mysqli_num_rows($total_users);

  date_default_timezone_set('Asia/Singapore');
  $current_month = date('m');
  $current_day = date('d');

  $total_logged = mysqli_query($conn,
  "SELECT DISTINCT account FROM account_log WHERE MONTH(log_in) = '$current_month' AND DAY(log_in) = '$current_day'");
  $total_logged_in = mysqli_num_rows($total_logged);

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
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Research Articles</p>
                    <h5 class="font-weight-bolder">
                      <?php if(!empty($total_research_articles)) echo $total_research_articles; else{ echo "0";}?>
                    </h5>
                    <p class="mb-0">
                      <a href="admin_journal.php" class="text-primary text-sm font-weight-bolder">View More <i class="fa fa-arrow-circle-right"></i></a>
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="ni ni-folder-17 text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
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
                      <a href="admin_cabinet.php" class="text-primary text-sm font-weight-bolder">View More <i class="fa fa-arrow-circle-right"></i></a>
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
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card animate-c">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Logged In</p>
                    <h5 class="font-weight-bolder">
                      <?php if(!empty($total_logged_in)) echo $total_logged_in; else{ echo "0";}?>
                    </h5>
                    <p class="mb-0">
                      <a href="admin_account_log.php" class="text-primary text-sm font-weight-bolder">View More <i class="fa fa-arrow-circle-right"></i></a>
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i class="ni ni-laptop text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card animate-c">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Users</p>
                    <h5 class="font-weight-bolder">
                      <?php if(!empty($total_users_acc)) echo $total_users_acc; else{ echo "0";}?>
                    </h5>
                    <p class="mb-0">
                      <a href="users.php" class="text-primary text-sm font-weight-bolder">View More <i class="fa fa-arrow-circle-right"></i></a>
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                    <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-5">
        <div class="col-lg-4 col-sm-6 mb-xl-0 mb-4">
          <div class="card card-size">
            <div class="card-header">
                Users Logged Today
            </div>
              <div class="card-body d-flex justify-content-center p-3">
              <canvas id="myChart" ></canvas>
                <?php
                  if(!empty($total_logged_in && $total_users_acc)){
                    $stat_logged = array($total_logged_in, $total_users_acc-$total_logged_in);
                  }
                ?>
                 <script>
                      const ctx = document.getElementById('myChart').getContext('2d');
                      const myChart = new Chart(ctx, {
                          type: 'bar',
                          data: {
                              labels: ['User logged in', 'User not logged'],
                              datasets: [{
                                  label: '# of logged',
                                  data: <?php if(!empty($stat_logged)){echo json_encode($stat_logged);} ?>,
                                  backgroundColor: [
                                      'rgba(75, 192, 192, 0.2)',
                                      'rgba(54, 162, 235, 0.2)'
                                  ],
                                  borderColor: [
                                      'rgba(75, 192, 192, 1)',
                                      'rgba(54, 162, 235, 1)'
                                  ],
                                  borderWidth: 1
                              }]
                          },
                          options: {
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        },
                        plugins: [ChartDataLabels],
                            options: {
                                maintainAspectRatio: false,
                                plugins: {
                                    datalabels: {
                                        color: '#336699',
                                        font: {
                                            weight: 'bold',
                                            size: 16
                                        }
                                    }
                                }
                            }
                      });
                 </script>
              </div>
          </div>
      	</div>
      	<div class="col-lg-4 col-sm-6 mb-xl-0 mb-4">
          <div class="card card-size">
              <div class="card-header">
                  Submitted Files per Status
              </div>
              <div class="card-body d-flex justify-content-center p-3">
              <canvas id="myChart2"></canvas>
                  <?php
                    $research_statuses = array('Pending', 'Approved', 'Revision', 'Rejected');
                    $statues_result = [];
                    foreach ($research_statuses as $research_status) {
                        $status_research = mysqli_query($conn,
                        "SELECT * FROM research_documents WHERE instatus='active' AND status='$research_status'");
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
                          plugins: [ChartDataLabels],
                            options: {
                                maintainAspectRatio: false,
                                plugins: {
                                    datalabels: {
                                        color: 'whitesmoke',
                                        font: {
                                            weight: 'bold',
                                            size: 16
                                        }
                                    }
                                }
                            }
                          });
                 </script>
                  
              </div>
          </div>
      	</div>
      	<div class="col-lg-4 col-sm-6 mb-xl-0 mb-4">
          <div class="card card-size">
              <div class="card-header">
                  Completed Research
              </div>
              	<div class="card-body p-3">
              	<canvas id="myChart3"></canvas>
                  <?php
                    $file_publish = mysqli_query($conn,
                    "SELECT * FROM published_research WHERE format='imrad'");
                    $file_publish_total = mysqli_num_rows($file_publish);
                    $file_publish_total_array = array($file_publish_total);
                  ?>
                 	<script>
                      const ctx3 = document.getElementById('myChart3').getContext('2d');
                      const myChart3 = new Chart(ctx3, {
                          type: 'doughnut',
                          data: {
                              labels: ['Total Completed Research'],
                              datasets: [{
                                  label: 'Research Articles',
                                  data: <?php if(!empty($file_publish_total_array)){echo json_encode($file_publish_total_array);} ?>,
                                  backgroundColor: [
                                  'rgba(75, 192, 192, 1)',
                                  ],
                                  hoverOffset: 4,
                                  rotation: -180,
                              }]
                          },
                          plugins: [ChartDataLabels],
                            options: {
                                maintainAspectRatio: false,
                                plugins: {
                                    datalabels: {
                                        color: 'whitesmoke',
                                        font: {
                                            weight: 'bold',
                                            size: 16
                                        }
                                    }
                                }
                            }
                      });
                 	</script>
              	</div>
          	</div>
      	</div>
  		</div>

      <div class="row mt-4">
        <div class="col-lg-6 col-sm-6 mb-xl-0 mb-4">
          <div class="card card-size">
            <div class="card-header">
                Submitted Research per Category
            </div>

            <div class="card-body d-flex justify-content-center p-3">
              <canvas id="myChart4"></canvas> 
              <?php
                $research_degrees = array('Graduates', 'Faculty', 'College', 'Senior High School');
                $research_per_category = [];

                foreach ($research_degrees as $research_degree) {
                  $total_research = mysqli_query($conn,
                  "SELECT research_documents.*,users.role
                  FROM research_documents,users
                  WHERE users.role='$research_degree' AND research_documents.status<>'Published' AND research_documents.instatus<>'inactive' AND research_documents.submitted_by=users.id");
                  $research_rows = mysqli_num_rows($total_research);
                  
                  if($research_degree == "Graduates"){
                    $research_per_category[] = $research_rows;
                  }
                  if($research_degree == "Faculty"){
                    $research_per_category[] = $research_rows;
                  }
                  if($research_degree == "College"){
                    $research_per_category[] = $research_rows;
                  }
                  if($research_degree == "Senior High School"){
                    $research_per_category[] = $research_rows;
                  }
                }
              ?> 
                <script>
                  const ctx4 = document.getElementById('myChart4').getContext('2d');
                  const myChart4 = new Chart(ctx4, {
                      type: 'polarArea',
                      data: {
                          labels: ['Graduates', 'Faculty', 'College', 'Senior High School'],
                          datasets: [{
                              label: 'Submitted Files per category',
                              data: <?php if(!empty($research_per_category)){echo json_encode($research_per_category);} ?>,
                              backgroundColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgb(60, 179, 113)'
                              ],
                              hoverOffset: 2
                          }]
                      },
                      plugins: [ChartDataLabels],
                            options: {
                                maintainAspectRatio: false,
                                plugins: {
                                    datalabels: {
                                        color: 'whitesmoke',
                                        font: {
                                            weight: 'bold',
                                            size: 16
                                        }
                                    }
                                }
                            }
                      });
                </script>  
              </div>
          </div>
        </div> 
        <div class="col-lg-6 col-sm-6 mb-xl-0 mb-4">
            <div class="card card-size">
              <div class="card-header">
                  Submitted Research per type
              </div>

              <div class="card-body d-flex justify-content-center p-3">
                <canvas id="myChart5"></canvas> 
                <?php
                  $research_types = array('Proposal', 'Capstone', 'Thesis', 'Dissertation');
                  $research_per_type = [];

                  foreach ($research_types as $research_type) {
                    $total_research_type = mysqli_query($conn,
                    "SELECT type_r FROM research_documents WHERE type_r='$research_type' AND instatus<>'inactive' AND status<>'Published'");
                    $research_rows_type = mysqli_num_rows($total_research_type);

                    if($research_type == "Proposal"){
                      $research_per_type[] = $research_rows_type;
                    }
                    if($research_type == "Capstone"){
                      $research_per_type[] = $research_rows_type;
                    }
                    if($research_type == "Thesis"){
                      $research_per_type[] = $research_rows_type;
                    }
                    if($research_type == "Dissertation"){
                      $research_per_type[] = $research_rows_type;
                    }
                  } 
                ?> 
                  <script>
                    const ctx5 = document.getElementById('myChart5').getContext('2d');
                    const myChart5 = new Chart(ctx5, {
                        type: 'bar',
                        data: {
                            labels: ['Proposal', 'Capstone', 'Thesis', 'Dissertation'],
                            datasets: [{
                                label: 'Type of Research',
                                data: <?php if(!empty($research_per_type)){echo json_encode($research_per_type);} ?>,
                                backgroundColor: [
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1,
                            }]
                        },
                        options: {
                          plugins: {
                              legend: {
                                  display: false
                              }
                          },
                          maintainAspectRatio: false,
                          scales: {
                              y: {
                                  beginAtZero: true
                              }
                          }
                      },
                      plugins: [ChartDataLabels],
                          options: {
                              maintainAspectRatio: false,
                              indexAxis: 'y',
                              plugins: {
                                  datalabels: {
                                      color: '#336699',
                                      font: {
                                          weight: 'bold',
                                          size: 16
                                      }
                                  }
                              }
                          }
                        });
                  </script>  
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
<?php 
    $title = "Research Statistic";
    require_once "db.php";
    include_once 'header.php';

    $current_year = date('Y');
    $past_five_years = array($current_year,$current_year-1,$current_year-2,$current_year-3,$current_year-4);
?>
<main class="main-content mt-0">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11" style="background-image: url('../image/sign.png'); background-position: top;">
      <span class="mask bg-gradient-secondary opacity-4"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Research Statistics</h1>
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
                            <div class="col-lg-4 col-sm-6 mb-xl-0 mb-4">
                                <div class="card card-size">
                                <div class="card-header">
                                    Number of Researchers
                                </div>
                                    <div class="card-body d-flex justify-content-center p-3">
                                    <canvas id="myChart" ></canvas>
                                        <?php
                                            $researchers_per_year = [];

                                            foreach ($past_five_years as $year) {

                                                $researchers = mysqli_query($conn,
                                                "SELECT * FROM users WHERE YEAR(date_created)='$year' AND role<>'Administrator' AND role<>'Adviser'");
                                                $researchers_rows = mysqli_num_rows($researchers);
                                        
                                                $researchers_per_year[] = $researchers_rows;
                                            }
                                        ?>
                                        <script>
                                            const ctx = document.getElementById('myChart').getContext('2d');
                                            const myChart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: <?php if(!empty($past_five_years)){echo json_encode($past_five_years);} ?>,
                                                    datasets: [{
                                                        label: 'Researchers',
                                                        data: <?php if(!empty($researchers_per_year)){echo json_encode($researchers_per_year);} ?>,
                                                        backgroundColor: [
                                                            'rgb(179, 255, 255)',
                                                            
                                                        ],
                                                        borderColor: [
                                                            'rgb(51, 255, 255)',
                                                            
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
                                                                color: 'darkblue',
                                                                font: {
                                                                    weight: 'bold',
                                                                    size: 12
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
                                       Number of Users
                                    </div>
                                    <div class="card-body d-flex justify-content-center p-3">
                                    <canvas id="myChart2"></canvas>
                                        <?php
                                            $users_per_year = [];

                                            foreach ($past_five_years as $year) {

                                                $users = mysqli_query($conn,
                                                "SELECT * FROM users WHERE YEAR(date_created)='$year'");
                                                $users_rows = mysqli_num_rows($users);
                                        
                                                $users_per_year[] = $users_rows;
                                            }
                                        ?>
                                        <script>
                                            const ctx2 = document.getElementById('myChart2').getContext('2d');
                                            const myChart2 = new Chart(ctx2, {             
                                                type: 'bar',
                                                data: {
                                                    labels: <?php if(!empty($past_five_years)){echo json_encode($past_five_years);} ?>,
                                                    datasets: [{
                                                        label: 'Total Users',
                                                        data: <?php if(!empty($users_per_year)){echo json_encode($users_per_year);} ?>,
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
                            <div class="col-lg-4 col-sm-6 mb-xl-0 mb-4">
                                <div class="card card-size">
                                    <div class="card-header">
                                        Completed Research
                                    </div>
                                    <div class="card-body p-3">
                                    <canvas id="myChart3"></canvas>
                                        <?php
                                            $file_publish = mysqli_query($conn,
                                            "SELECT * FROM published_research");
                                            $file_publish_total = mysqli_num_rows($file_publish);
                                            $file_publish_total_array = array($file_publish_total);
                                        ?>
                                        <script>
                                            const ctx3 = document.getElementById('myChart3').getContext('2d');
                                            const myChart3 = new Chart(ctx3, {
                                                type: 'doughnut',
                                                data: {
                                                    labels: ["Total Completed Research"],
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

                        <div class="row mt-3">
                            <div class="col-lg-4 col-sm-6 mb-xl-0 mb-4">
                                <div class="card card-size">
                                    <div class="card-header">
                                        Completed Research per Category
                                    </div>
                                    <div class="card-body p-3">
                                    <canvas id="myChart4"></canvas>
                                        <?php
                                            $research_degrees = array('Graduates', 'Faculty', 'College', 'Senior High School');
                                            $completed_research_per_category = [];

                                            foreach ($research_degrees as $research_degree) {
                                                $total_research = mysqli_query($conn,
                                                "SELECT published_research.*,research_documents.*,users.role
                                                FROM published_research,research_documents,users
                                                WHERE users.role='$research_degree' AND research_documents.status='Published' AND published_research.document=research_documents.id AND research_documents.submitted_by=users.id");
                                                $research_rows = mysqli_num_rows($total_research);
                                                
                                                if($research_degree == "Graduates"){
                                                    $completed_research_per_category[] = $research_rows;
                                                }
                                                if($research_degree == "Faculty"){
                                                    $completed_research_per_category[] = $research_rows;
                                                }
                                                if($research_degree == "College"){
                                                    $completed_research_per_category[] = $research_rows;
                                                }
                                                if($research_degree == "Senior High School"){
                                                    $completed_research_per_category[] = $research_rows;
                                                }
                                            }
                                        ?>
                                        <script>
                                            const ctx4 = document.getElementById('myChart4').getContext('2d');
                                            const myChart4 = new Chart(ctx4, {
                                                type: 'polarArea',
                                                data: {
                                                    labels: ['Graduates','Faculty','College','SHS'],
                                                    datasets: [{
                                                        label: 'Research Status',
                                                        data: <?php if(!empty($completed_research_per_category)){echo json_encode($completed_research_per_category);} ?>,
                                                        backgroundColor: [
                                                        'rgba(75, 192, 192, 1)',
                                                        'rgba(54, 162, 235, 1)',
                                                        'rgba(255, 206, 86, 1)',
                                                        'rgb(60, 179, 113)'
                                                        ],
                                                        hoverOffset: 2
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
                                        Number of Submitted Documents
                                    </div>
                                    <div class="card-body p-3">
                                    <canvas id="myChart5"></canvas>
                                        <?php
                                            $submitted_research_per_year = [];

                                            foreach ($past_five_years as $year) {

                                                $submitted_research = mysqli_query($conn,
                                                "SELECT * FROM research_documents WHERE YEAR(date_submitted)='$year' AND status<>'Published'");
                                                $submitted_research_rows = mysqli_num_rows($submitted_research);
                                        
                                                $submitted_research_per_year[] = $submitted_research_rows;
                                            }
                                        ?>
                                        <script>
                                            const ctx5 = document.getElementById('myChart5').getContext('2d');
                                            const myChart5 = new Chart(ctx5, {
                                                type: 'bar',
                                                data: {
                                                    labels: <?php if(!empty($past_five_years)){echo json_encode($past_five_years);} ?>,
                                                    datasets: [{
                                                        label: '# Submitted Files',
                                                        data: <?php if(!empty($submitted_research_per_year)){echo json_encode($submitted_research_per_year);} ?>,
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
                                    Number of Documents Checked
                                </div>
                                    <div class="card-body d-flex justify-content-center p-3">
                                    <canvas id="myChart6" ></canvas>
                                        <?php
                                            $checked_research_per_year = [];

                                            foreach ($past_five_years as $year) {

                                                $checked_research = mysqli_query($conn,
                                                "SELECT * FROM research_documents WHERE YEAR(date_submitted)='$year' AND status<>'Pending' AND status<>'Published'");
                                                $checked_research_rows = mysqli_num_rows($checked_research);
                                        
                                                $checked_research_per_year[] = $checked_research_rows;
                                            }
                                        ?>
                                        <script>
                                            const ctx6 = document.getElementById('myChart6').getContext('2d');
                                            const myChart6 = new Chart(ctx6, {
                                                type: 'line',
                                                data: {
                                                    labels: <?php if(!empty($past_five_years)){echo json_encode($past_five_years);} ?>,
                                                    datasets: [{
                                                        label: 'Documents checked',
                                                        data: <?php if(!empty($checked_research_per_year)){echo json_encode($checked_research_per_year);} ?>,
                                                        backgroundColor: [
                                                            'rgba(75, 192, 192, 0.2)',
                                                            'rgba(54, 162, 235, 0.2)',
                                                            'rgba(255, 206, 86, 0.2)',
                                                            'rgba(75, 192, 192, 0.2)',
                                                            'rgba(153, 102, 255, 0.2)',
                                                            'rgba(255, 159, 64, 0.2)'
                                                        ],
                                                        borderColor: 'rgb(255,255,0)',
                                                        borderWidth: 1,
                                                        tension: 0.6
                                                    }]
                                                },
                                                options: {  
                                                    plugins: {
                                                        legend: {
                                                            display: false
                                                        }
                                                    },
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
                                                                color: 'darkblue',
                                                                font: {
                                                                    weight: 'bold',
                                                                    size: 12
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
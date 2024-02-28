<?php 
  session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../image/rikdologo.png">
  <title>
  <?php 
   echo $title;
  ?>
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />

  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="../cdnjs/jquery-1.10.2.min.js"></script>
  <script src="../cdnjs/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>
  <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
  </script>
  <style>
    body::-webkit-scrollbar {
      width: 12px;               /* width of the entire scrollbar */
    }

    body::-webkit-scrollbar-track {
      background: #f4f5f7;        /* color of the tracking area */
    }

    body::-webkit-scrollbar-thumb {
      background-color: #11cdef;    /* color of the scroll thumb */
      border-radius: 20px;       /* roundness of the scroll thumb */
      border: 3px solid #f4f5f7;  /* creates padding around scroll thumb */
    }
    #table{
      border-collapse: collapse;
      margin: 0;
      padding: 0;
      width: 100%;
      table-layout: auto;
      font-size: 14px;
    }
      #table tr {
      padding: .35em;
    }
    #table tr:hover {background-color: #f2f2f2;}

    #table th{
      font-family: sans-serif;
      font-weight: bold;
      border-top: 1px solid #004d99;
    }
    #table th,
    #table td {
      padding: 1em;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    #table th {
      font-size: .85em;
      letter-spacing: .1em;
      text-transform: uppercase;
      background: #004d99;
      color: white;
    }
    @media screen and (max-width: 600px) {
  #table {
    border: 0;
  }

  #table caption {
    font-size: 1.3em;
  }
  
  #table thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }
  
  #table tr {
    border: 1px solid #ddd;
    display: block;
    margin-bottom: .625em;
  }
  
  #table td {
    border-bottom: 1px solid #ddd;
    display: block;
    text-align: center;
  }
  
  #table td::before {
    /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }
  
  #table td:last-child {
    border-bottom: 0;
  }
}
#article-contents{
  max-height: 35em;
  overflow-y: scroll;
}
  #article-contents::-webkit-scrollbar {
      width: 12px;               /* width of the entire scrollbar */
    }

    #article-contents::-webkit-scrollbar-track {
      background: #f4f5f7;        /* color of the tracking area */
    }

    #article-contents::-webkit-scrollbar-thumb {
      background-color: #11cdef;    /* color of the scroll thumb */
      border-radius: 20px;       /* roundness of the scroll thumb */
      border: 3px solid #f4f5f7;  /* creates padding around scroll thumb */
    }
  .animate-con:hover{
    background: #ccffff;
  }  
  .graph-admin{
    max-width: 300px;
    }
    .bar-admin{
    max-width: 500px;
    }
    .card-size{
    min-height: 450px;
    }
  #open-docu{
    position:absolute;
    bottom: 5px;
    left: 0%;
    right: 0%;
    text-align: center;
  }
  </style>
</head>

<body class="d-flex flex-column min-vh-100">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4" style="float: right;">
          <div class="container-fluid">
            <img src="../image/rikdologo.png" height="20px" width="20px" alt="main_logo" style="margin-right: 10px;">
            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="research.php">
              RIKDO DMS
            </a>
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
            <div class="collapse navbar-collapse" id="navigation">
              <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center me-2 active" aria-current="page" href="research.php">
                    <i class="fas fa-book opacity-6 text-dark me-1"></i>
                    Articles
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center me-2 active" aria-current="page" href="graduates.php">
                    <i class="fa fa-graduation-cap opacity-6 text-dark me-1"></i><i class=""></i>
                    Graduates
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center me-2 active" aria-current="page" href="faculty.php">
                    <i class="fas fa-chalkboard-teacher opacity-6 text-dark me-1"></i>
                    Faculty
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center me-2 active" aria-current="page" href="college.php">
                    <i class="fa fa-university opacity-6 text-dark me-1"></i>
                    College
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center me-2 active" aria-current="page" href="shs.php">
                    <i class="fa fa-school opacity-6 text-dark me-1"></i>
                    SHS
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center me-2 active" aria-current="page" href="stat.php">
                    <i class="fa fa-chart-pie opacity-6 text-dark me-1"></i>
                    Chart
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center me-2 bg-primary rounded" aria-current="page" href="signin.php" style="color: white;">
                    <i class="fas fa-key opacity-6 me-1" style="color: white;"></i>
                    Sign in
                  </a>
                </li>
                <li class="nav-item" >
                  <a class="nav-link me-2 bg-dark rounded" href="signup.php" style="color: white;">
                    <i class="fas fa-user-circle opacity-6 me-1" style="color: white;"></i>
                    Register
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
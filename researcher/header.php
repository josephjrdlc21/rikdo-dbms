<?php 
  session_start();
  require_once "db.php";

  if(isset($_SESSION['account_researcher'])){
      $name = $_SESSION['account_researcher'];
      $id = $_SESSION['idaccount_researcher'];
      $logout_id = $_SESSION['researcher_unique_id'];

      $result_login = mysqli_query($conn,"SELECT * FROM users WHERE id='$id'");
      $row_login  = mysqli_fetch_assoc($result_login);

      $profile = $row_login['profile'];
  }

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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script type="text/javascript" src="https://unpkg.com/chart.js-plugin-labels-dv/dist/chartjs-plugin-labels.min.js"></script>
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="../cdnjs/jquery-1.10.2.min.js"></script>
  <script src="../cdnjs/jquery.min.js"></script>
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
  .animate-c:hover{
    transform: scale(1.1);
  }
  .animate-c{
    transition: transform .5s;
  }
  .nav-hov:hover{
    background: #f2f2f2;
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
      border-top: 1px solid #ddd;
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
      background: #f6f9fc;
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
#editor-container{
    height: 150px;
  }


/*responsive*/
  </style>
</head>
<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 position-absolute w-100 bg-gradient-info"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="  " target="_blank">
        <img src="../image/rikdologo.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">RIKDO DMS</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link nav-hov <?php if($title == "dashboard"){echo "active";} ?>" href="dashboard.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-dashboard text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-hov <?php if($title == "Submit a file"){echo "active";} ?>" href="submit.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-clone text-success text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Submit Research</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-hov <?php if($title == "Research Files"){echo "active";} ?>" href="research.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-folder text-sm opacity-10" style="color: #9999ff"></i>
            </div>
            <span class="nav-link-text ms-1">Research Files</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-hov <?php if($title == "My Profile"){echo "active";} ?>" href="profile.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page"><?php echo $title; ?></li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0"><?php echo $title; ?></h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            
          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="profile.php" class="nav-link text-white font-weight-bold px-0">
                <img src="../profile/<?php if(!empty($profile)){echo $profile;} ?>" style="margin-right: 10px;" class="shadow rounded-circle" alt="main_logo" height="40px" width="40px">
                <span class="d-sm-inline d-none"> <?php if(!empty($name)){echo $name;} ?></span>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="../hub/signin.php?logout_id=<?php echo $logout_id;?>" class="nav-link text-white p-0">
                <i class="fas fa-power-off fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
            
          </ul>
        </div>
      </div>
    </nav>
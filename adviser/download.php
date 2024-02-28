<?php
    require_once "db.php";
       
    if(isset($_GET['files'])){

        $id = $_GET['id'];

        $download = mysqli_query($conn,"INSERT INTO action_done (document, type) VALUES ('$id', 'download')");

        $result = mysqli_query($conn,"SELECT adviser, research_title FROM research_documents WHERE id='$id'");
        $row_file  = mysqli_fetch_assoc($result);

        $adviser = $row_file['adviser'];
        $title = $row_file['research_title'];

        $activity = "Downloads a research document entitled " . $title;
        $activity_log_sql = mysqli_query($conn,"INSERT INTO activity_log (account, activity, created_at) VALUES ('$adviser', '$activity', now())");

        $filename = $_GET['files']; // YOUR File name retrive from database
        $file= "../documents/".$filename; // YOUR Root path for pdf folder storage
        
        header("Content-Type: application/msword");
        header("Content-Disposition: attachment; filename=" . $filename);
        header("Content-Length: " . filesize($file));
        readfile($file);
        exit;
    }
?>
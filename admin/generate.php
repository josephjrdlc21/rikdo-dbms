<?php
    session_start();
    require_once "db.php";
    require_once __DIR__ . '/vendor/autoload.php';

    $adviser = $_SESSION['idaccount_admin'];

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $id = urlencode($id);

        $activity = "Generate pdf inventory reports";
        $activity_log_sql = mysqli_query($conn,"INSERT INTO activity_log (account, activity, created_at) VALUES ('$adviser', '$activity', now())");
    }

    $mpdf = new \Mpdf\Mpdf();

    $url = "http://localhost/dbms2/system/admin/report_content.php?id=$id";
    $result = file_get_contents($url);

    $mpdf->WriteHTML($result);

    $mpdf->Output('RIKDO_DMS_report.pdf', 'D');
?>
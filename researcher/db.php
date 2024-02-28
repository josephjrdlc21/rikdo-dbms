<?php
    $dblocalhost = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "dms";

    $conn = mysqli_connect($dblocalhost, $dbusername, $dbpassword, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>
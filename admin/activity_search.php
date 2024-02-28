<?php
    session_start();
    require_once "db.php";

    if(isset($_POST['input'])){

        $input = $_POST['input'];

        if(isset($_SESSION['year2'])){
            $year = $_SESSION['year2'];
        }
     
        if(!empty($input)){
            $sql_search_log = mysqli_query($conn," SELECT activity_log.*,users.profile,users.role,users.idnum,users.firstname,users.lastname FROM activity_log,users 
            WHERE activity_log.account=users.id AND YEAR(created_at)=$year AND (lastname LIKE '{$input}%' OR firstname LIKE '{$input}%'
            OR MONTH(created_at) LIKE '%{$input}%' OR idnum LIKE '{$input}%' OR role LIKE '{$input}%') ORDER BY activity_log.id DESC");
        }
        else{
            $sql_search_log = mysqli_query($conn,"SELECT activity_log.*,users.profile,users.role,users.idnum,users.firstname,users.lastname FROM activity_log,users 
            WHERE activity_log.account=users.id  AND YEAR(created_at)=$year ORDER BY activity_log.id DESC LIMIT 7");
        }

    }
?>
<?php
    if (mysqli_num_rows($sql_search_log) > 0) {
        $count = 1;
        while($row_user_log = mysqli_fetch_array($sql_search_log)) {
?>
            <tr>
                <td><input type="checkbox" class="checkItem" value="<?= $row_user_log["id"];?>" name="file_id[]"></td>
                <td><img src="../profile/<?= $row_user_log["profile"];?>" class="shadow rounded-circle" alt="profile" height="50px" width="50px"></td>
                <td><?= $row_user_log["idnum"];?></td>
                <td><?= $row_user_log["role"];?></td>
                <td><?= $row_user_log["firstname"] . " " . $row_user_log["lastname"];?></td>
                <td><?= $row_user_log["activity"];?></td>
                <td><?php if(isset($row_user_log["created_at"])){echo date("F j, Y, g:i a", strtotime($row_user_log["created_at"]));}  ?></td>
            </tr>
            
<?php
        $count++;
        }
    }
?>
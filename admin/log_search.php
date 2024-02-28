<?php
    session_start();
    require_once "db.php";

    if(isset($_POST['input'])){

        $input = $_POST['input'];

        if(isset($_SESSION['year'])){
            $year = $_SESSION['year'];
        }
     
        if(!empty($input)){
            $sql_search_log = mysqli_query($conn," SELECT account_log.*,users.profile,users.role,users.idnum,users.firstname,users.lastname FROM account_log,users 
            WHERE account_log.account=users.id AND (YEAR(log_in)=$year OR YEAR(log_out)=$year) AND (lastname LIKE '{$input}%' OR firstname LIKE '{$input}%'
            OR MONTH(log_in) LIKE '%{$input}%' OR idnum LIKE '{$input}%' OR role LIKE '{$input}%') ORDER BY account_log.id DESC");
        }
        else{
            $sql_search_log = mysqli_query($conn,"SELECT account_log.*,users.profile,users.role,users.idnum,users.firstname,users.lastname FROM account_log,users 
            WHERE account_log.account=users.id  AND (YEAR(log_in)=$year OR YEAR(log_out)=$year) ORDER BY account_log.id DESC LIMIT 7");
        }

    }
?>
<?php
    if (mysqli_num_rows($sql_search_log) > 0) {
        $count = 1;
        while($row_user_log = mysqli_fetch_array($sql_search_log)) {
?>
             <tr>
                <td><input type="checkbox" class="checkItem" value="<?= $row_user_log["id"];?>" name="file_id[]" 
                <?php 
                if(empty($row_user_log["log_in"]) || empty($row_user_log["log_out"])){
                    echo "disabled";
                }
                
                ?>
                ></td>
                <td><img src="../profile/<?= $row_user_log["profile"];?>" class="shadow rounded-circle" alt="profile" height="50px" width="50px"></td>
                <td><?= $row_user_log["idnum"];?></td>
                <td><?= $row_user_log["role"];?></td>
                <td><?= $row_user_log["firstname"] . " " . $row_user_log["lastname"];?></td>
                <td><span class="badge badge-sm bg-gradient-success"><?php if(isset($row_user_log["log_in"])){echo date("F j, Y, g:i a", strtotime($row_user_log["log_in"]));}  ?></span></td>
                <td><span class="badge badge-sm bg-gradient-danger"><?php if(isset($row_user_log["log_out"])){echo date("F j, Y, g:i a", strtotime($row_user_log["log_out"]));}  ?></span></td>
            </tr>
            
<?php
        $count++;
        }
    }
?>
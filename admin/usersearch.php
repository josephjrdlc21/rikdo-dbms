<?php
    require_once "db.php";

    if(isset($_POST['input'])){

        $input = $_POST['input'];

        if(!empty($input)){

            $sql_search_user = mysqli_query($conn,"SELECT * FROM users WHERE (lastname LIKE '{$input}%' OR firstname LIKE '{$input}%'
            OR idnum LIKE '{$input}%' OR status LIKE '{$input}%' OR YEAR(date_created) LIKE '%{$input}%' OR MONTH(date_created) LIKE '%{$input}%')");
        }
        else{
            $sql_search_user = mysqli_query($conn,"SELECT * FROM users ORDER BY date_created DESC LIMIT 7");
        }
    }
?>
<?php
    if (mysqli_num_rows($sql_search_user) > 0) {
        while($row_user_list = mysqli_fetch_array($sql_search_user)) {
?>
            <tr>
                <td><input type="checkbox" class="checkItem" value="<?= $row_user_list["id"];?>" name="user_id[]"
                <?php 
                    $this_id = $row_user_list["id"];
                    $check_research_exits = mysqli_query($conn,"SELECT * FROM research_documents WHERE submitted_by='$this_id' OR adviser='$this_id' LIMIT 1");

                    if(mysqli_num_rows($check_research_exits) > 0){
                        echo "disabled";
                    }
                ?>
                ></td>
                <td><img src="../profile/<?= $row_user_list["profile"];?>" class="shadow rounded-circle" alt="profile" height="50px" width="50px"></td>
                <td><?= $row_user_list["idnum"];?></td>
                <td><?= $row_user_list["role"];?></td>
                <td><?= $row_user_list["firstname"] . " " . $row_user_list["lastname"];?></td>
                <td>
                    <?php 
                        if($row_user_list["status"] == "deactivated"){
                    ?>
                            <span class="badge badge-sm bg-gradient-danger">
                            <a href="users.php?ad=activated&&st=<?= $row_user_list["id"];?>" class="text-white" onclick="return confirm('Are you sure you want to deactivate?')">Deactivated</a>
                            </span>
                    
                    <?php 
                        }
                        else{
                    ?> 
                            <span class="badge badge-sm bg-gradient-success">
                            <a href="users.php?ad=deactivated&&st=<?= $row_user_list["id"];?>" class="text-white" onclick="return confirm('Are you sure you want to activate?')">Activated</a>
                            </span>
                    
                    <?php 
                        }
                    ?> 
                                                                
                </td>
                <td><?php echo date("F j, Y", strtotime($row_user_list["date_created"])); ?></td>
                <td><a href="view_users.php?editid=<?= $row_user_list["id"];?>" type="button" class="btn btn-sm btn-info" ><i class="fa fa-user-circle"></i> View</a></td>
            </tr>   
<?php
        }
    }
?>
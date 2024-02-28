<?php
    session_start();
    require_once "db.php";

    if(isset($_POST['input'])){

        $input = $_POST['input'];

        if(!empty($input)){
            $sql_search_file = mysqli_query($conn,"SELECT research_documents.*, users.firstname, users.lastname, degree_strand.ds_code
            FROM research_documents,users,degree_strand
            WHERE research_documents.status<>'Published' AND research_documents.instatus='inactive'
            AND (research_documents.research_title LIKE '%{$input}%' OR research_documents.authors LIKE '%{$input}%' OR research_documents.type_r LIKE '%{$input}%' OR research_documents.chapter LIKE '%{$input}%'
            OR YEAR(research_documents.date_submitted) LIKE '%{$input}' OR MONTH(research_documents.date_submitted) LIKE '%{$input}')
            AND (research_documents.adviser=users.id AND research_documents.degree_strand=degree_strand.id) 
            ORDER BY research_documents.date_submitted DESC");
        }
        else{
            $sql_search_file = mysqli_query($conn,"SELECT research_documents.*, users.firstname, users.lastname, degree_strand.ds_code
            FROM research_documents,users,degree_strand
            WHERE research_documents.status<>'Published' AND research_documents.instatus='inactive'
            AND (research_documents.adviser=users.id AND research_documents.degree_strand=degree_strand.id)
            ORDER BY research_documents.date_submitted DESC
            LIMIT 7");    
        }
    }
?>
<?php
    if (mysqli_num_rows($sql_search_file) > 0) {
        while($row_files_list = mysqli_fetch_array($sql_search_file)) {
?>
            <tr>
                <td><input type="checkbox" class="checkItem" value="<?= $row_files_list["id"];?>" name="file_id[]"></td>
                <td>
                <a href="view_file.php?fileid=<?= $row_files_list["id"];?>" class="text-primary"><?= $row_files_list["research_title"];?></a>
                <br><small><?= $row_files_list["authors"];?>
                <br> 
                    <i class="fa fa-eye text-info"></i> 
                    <?php
                        $viewid = $row_files_list["id"];
                        $view = mysqli_query($conn,
                        "SELECT * FROM action_done WHERE document='$viewid' AND type='view'");
                        $view_rows = mysqli_num_rows($view);

                        if(!empty($view_rows)){ echo $view_rows; } else{ echo 0;}
                    ?>
                    <i class="fa fa-download text-danger"></i> 
                    <?php
                        $downloadid = $row_files_list["id"];
                        $download = mysqli_query($conn,
                        "SELECT * FROM action_done WHERE document='$downloadid' AND type='download'");
                        $download_rows = mysqli_num_rows($download);

                        if(!empty($download_rows)){ echo $download_rows; } else{ echo 0;}
                    ?>
                    <i class="fa fa-comment text-warning"></i> 
                    <?php
                        $commentid = $row_files_list["id"];
                        $comment = mysqli_query($conn,
                        "SELECT * FROM comments WHERE document='$commentid'");
                        $comment_rows = mysqli_num_rows($comment);

                        if(!empty($comment_rows)){ echo $comment_rows; } else{ echo 0;}
                    ?>
                    </small>
                </td>
                <td><?= $row_files_list["type_r"];?></td>
                <td><span class="badge badge-sm bg-gradient-<?php 
                    if($row_files_list["status"] == "Pending"){
                        echo "primary";
                    }
                    elseif($row_files_list["status"] == "Approved"){
                        echo "success";
                    }
                    elseif($row_files_list["status"] == "Revision"){
                        echo "warning";
                    }
                    else{
                        echo "danger";
                    }
                ?>"><?= $row_files_list["status"];?></span></td>
                <td><span class="badge badge-sm bg-gradient-secondary"><?= $row_files_list["chapter"];?></span></td>
                <td><span class="badge badge-sm bg-gradient-secondary"><?= $row_files_list["version"];?></span></td>
                <td><?php echo date("F j, Y, g:i a", strtotime($row_files_list["date_submitted"])); ?></td>
                <td><?= $row_files_list["ds_code"];?></td>
                <td><?= $row_files_list["firstname"] . " " . $row_files_list["lastname"];?></td></td>
            </tr>
<?php
        }
    }
?>
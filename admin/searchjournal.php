<?php
    session_start();
    require_once "db.php";

    if(isset($_POST['input'])){

        $input = $_POST['input'];

        if(!empty($input)){
            $sql_search_file = mysqli_query($conn,"SELECT published_research.*,research_documents.*
            FROM published_research,research_documents
            WHERE published_research.document=research_documents.id 
            AND (research_documents.research_title LIKE '%{$input}%' OR research_documents.authors LIKE '%{$input}%' 
            OR YEAR(published_research.year) LIKE '%{$input}%' OR published_research.format LIKE '%{$input}%' OR published_research.publication LIKE '%{$input}%')
            ORDER BY published_research.id DESC");
        }
        else{
            $sql_search_file = mysqli_query($conn,"SELECT published_research.*,research_documents.*
            FROM published_research,research_documents
            WHERE published_research.document=research_documents.id
            ORDER BY published_research.id DESC
            LIMIT 7");
        }
    }
?>
<?php
    if (mysqli_num_rows($sql_search_file) > 0) {
        $count = 1;
        while($row_files_list = mysqli_fetch_array($sql_search_file)) {
?>
        <tr>
            <td><?php echo $count; ?></td>
            <td>
            <a href="view_published_research.php?fileid=<?= $row_files_list["id"];?>" class="text-primary"><?= $row_files_list["research_title"];?></a>
            <br><small><?= $row_files_list["authors"];?>
                <i class="fa fa-eye text-info"></i>
                <?php
                    $getid = $row_files_list["id"];

                    $publish = mysqli_query($conn,"SELECT id FROM published_research WHERE document='$getid'");
                    $row_publish  = mysqli_fetch_assoc($publish);
            
                    $viewid = $row_publish['id'];
                    
                    $view = mysqli_query($conn,
                    "SELECT * FROM publish_viewed WHERE published='$viewid'");
                    $view_rows = mysqli_num_rows($view);

                    if(!empty($view_rows)){ echo $view_rows; } else{ echo 0;}
                ?>
                </small>
            </td>
            <td>
                <?php 
                    
                    $ad = $row_files_list["adviser"];
                    $result_ad = mysqli_query($conn,"SELECT research_documents.*, users.firstname, users.lastname
                    FROM research_documents,users
                    WHERE research_documents.adviser='$ad' AND research_documents.adviser=users.id");
                    $row_ad  = mysqli_fetch_assoc($result_ad);

                    echo $row_ad["firstname"] . " " . $row_ad["lastname"]; 
                                                                        
                ?>
            </td>
            <td><?= strtoupper($row_files_list["format"])?></td>
            <td>
                <?php 
                    
                    $degree = $row_files_list["degree_strand"];
                    $result_degree = mysqli_query($conn,"SELECT research_documents.*, degree_strand.ds_code
                    FROM research_documents,degree_strand
                    WHERE research_documents.degree_strand='$degree' AND research_documents.degree_strand=degree_strand.id");
                    $row_degree  = mysqli_fetch_assoc($result_degree);

                    echo $row_degree["ds_code"]; 
                                                                        
                ?>
            </td>
            <td>
                <?php 
                    
                    $dept = $row_files_list["department"];
                    $result_dept = mysqli_query($conn,"SELECT research_documents.*, department.dept_code
                    FROM research_documents,department
                    WHERE research_documents.department='$dept' AND research_documents.department=department.id");
                    $row_dept  = mysqli_fetch_assoc($result_dept);

                    echo $row_dept["dept_code"]; 
                                                                        
                ?>
            </td>
            <td><?= $row_files_list["year"];?></td></td>
        </tr>
<?php
    $count++;
        }
    }
?>
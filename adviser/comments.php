<?php 
    $title = "Comments";
    include_once 'header.php';

    $adviser = $_SESSION['idaccount_adviser'];

    if(isset($_GET['fileid'])){

        $fileid = $_GET['fileid'];

        $result_edit_file = mysqli_query($conn,"SELECT * FROM research_documents WHERE id='$fileid'");
        $row_edit_file  = mysqli_fetch_assoc($result_edit_file);

        $id = $row_edit_file ['id'];
        $title = $row_edit_file ['research_title'];
        $authors = $row_edit_file ['authors'];
    }

    if(isset($_POST['submit'])){

        $comment = $_POST['editor_content'];
        $json = json_encode($comment);
        $trimmedString = substr($json, 1);
        $trimmedString = substr($trimmedString, 0, -1);
        $data = "'" . $trimmedString . "'";

        if(!empty($json)){
            $insert_comment_file = mysqli_query($conn,"INSERT INTO comments (document, commentor, message, date_comment)
            VALUES ('$id', '$adviser', '$trimmedString', now())");

            $activity = "Add comments on research entitled " . $title;
            $activity_log_sql = mysqli_query($conn,"INSERT INTO activity_log (account, activity, created_at) VALUES ('$adviser', '$activity', now())");
        }
    }
?>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <!-- End Navbar -->
    <div class="container py-4">
        <div class="row">
            <div class="col-lg grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-primary">Comments</h4>
                        <div class="row mt-4" style="overflow-x: auto;">

                            <div class="col-sm-12 col-md-12 col-lg-12" >
                                <div class="shadow-lg card card-plain mb-4">
                                    <div class="card-body">

                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label style="font-size: 15px;">Research Details</label>
                                                <textarea class="form-control" rows="2" disabled><?php echo $title . " by: " . $authors; ?></textarea>
                                            </div>
                                        </div>
                                          
                                        <div class="card card-plain mt-4">
                                            <div class="card-body">
                                                <?php
                                                    $show_comment_file = mysqli_query($conn,"SELECT comments.*,users.firstname,users.lastname,users.profile 
                                                    FROM comments,users WHERE document='$id' AND comments.commentor=users.id");

                                                    if (mysqli_num_rows($show_comment_file) > 0) {
                                                        while($row_comment_file = mysqli_fetch_array($show_comment_file)) {
                                                ?>
                                                        <div class="d-flex flex-start align-items-center">
                                                            <img class="rounded-circle shadow-1-strong me-3"
                                                            src="../profile/<?= $row_comment_file["profile"];?>" alt="avatar" width="60"
                                                            height="60" />
                                                            <div>
                                                                <h6 class="fw-bold mb-1"><?= $row_comment_file["firstname"] . " " . $row_comment_file["lastname"];?></h6>
                                                                <p class="text-muted small mb-0">
                                                                <?php echo date("F j, Y, g:i a", strtotime($row_comment_file["date_comment"])); ?>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="mt-3">
                                                            <?php
                                                                   
                                                            
                                                            $quillArrayJson = $row_comment_file["message"];
                                                            $quillArray = json_decode($quillArrayJson, true);

                                                            $html = '';
                                                            foreach ($quillArray['ops'] as $op) {
                                                                if (isset($op['insert'])) {
                                                                    $text = $op['insert'];
                                                              
                                                                  // Check for formatting attributes
                                                                    $bold = isset($op['attributes']['bold']) && $op['attributes']['bold'] === true ? 'bold' : '';
                                                                    $italic = isset($op['attributes']['italic']) && $op['attributes']['italic'] === true ? 'italic' : '';
                                                                    $underline = isset($op['attributes']['underline']) && $op['attributes']['underline'] === true ? 'underline' : '';
                                                                    $strike = isset($op['attributes']['strike']) && $op['attributes']['strike'] === true ? 'line-through' : '';
                                                                    $list = isset($op['attributes']['list']) ? $op['attributes']['list'] : '';
                                                                    $header = isset($op['attributes']['header']) ? $op['attributes']['header'] : '';
                                                                    $color = isset($op['attributes']['color']) ? 'color: ' . $op['attributes']['color'] . ';' : '';
                                                                    $background = isset($op['attributes']['background']) ? 'background-color: ' . $op['attributes']['background'] . ';' : '';
                                                                    $align = isset($op['attributes']['align']) ? 'text-align: ' . $op['attributes']['align'] . ';' : '';
                                                                    $font = isset($op['attributes']['font']) ? 'font-family: ' . $op['attributes']['font'] . ';' : '';
                                                                    $size = isset($op['attributes']['size']) ? $op['attributes']['size'] . ';' : '';
                                                                    switch ($size) {
                                                                        case 'small;':
                                                                            $sizeNumeric = "14px";
                                                                            break;
                                                                        case 'normal;':
                                                                            $sizeNumeric = "16px";
                                                                            break;
                                                                        case 'large;':
                                                                            $sizeNumeric = "24px";
                                                                            break;
                                                                        case 'huge;':
                                                                            $sizeNumeric = "38px";
                                                                            break;
                                                                        default:
                                                                            $sizeNumeric = "16px";  // default value
                                                                    }
                                                              
                                                                  // Generate HTML with formatting
                                                                    if ($list === 'ordered') {
                                                                        $html .= '<ol>';
                                                                    } 
                                                                    elseif ($list === 'bullet') {
                                                                        $html .= '<ul>';
                                                                    }
                                                                    
                                                                    if ($header) {
                                                                        $html .= '<h' . $header . ' style="font-weight: ' . $bold . '; font-style: ' . $italic . '; text-decoration: ' . $underline . $strike . '; ' . $color . $background . $align . $font . '">' . $text . '</h' . $header . '>';
                                                                    } 
                                                                    else {
                                                                        $html .= '<span style="font-weight: ' . $bold . '; font-style: ' . $italic . '; text-decoration: ' . $underline . $strike . '; ' . $color . $background . $align . $font . '; font-size: ' . $sizeNumeric . '">' . $text . '</span>';
                                                                    }
                                                                    if ($list === 'ordered' || $list === 'bullet') {
                                                                        $html .= '</li></' . $list . '>';
                                                                    }
                                                                }
                                                                    
                                                            }
                                                            echo $html;                                                            
                                                            ?>
                                                        </div><br>
                                                <?php
                                                        }
                                                    }
                                                ?>

                                            </div>

                                            <form method="POST">
                                                <div id="editor-container"></div>
                                                <input type="hidden" name="editor_content">
                                                <br>
                                                <a href="view_file.php?fileid=<?php echo $fileid; ?>" class="btn btn-light btn-sm" style="float: right;">Cancel</a>     
                                                <button type="submit" name="submit" class="btn btn-dark btn-sm" style="float: right; margin-right: 5px;">Post comment</button>
                                            </form>

                                            
                                        </div>
                                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  	</div>
    
  </main>
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
    const toolbarOptions = [  ['bold', 'italic', 'underline', 'strike'],
        [{ 'size': [ 'small', false, 'large', 'huge' ]}],
        [{ 'font': [] }],
        [{ 'color': [] }, { 'background': [] }]
    ];
    var quill = new Quill('#editor-container', {
        modules: {
            toolbar: toolbarOptions  
        },
        theme: 'snow'
    });
    document.querySelector('form').onsubmit = function() {
    // Get the content of the editor
    var editorContent = quill.getContents();

    // Convert the content to a string
    var editorContentString = JSON.stringify(editorContent);

    // Set the value of the hidden form field
    document.querySelector('input[name="editor_content"]').value = editorContentString;
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>
</html>
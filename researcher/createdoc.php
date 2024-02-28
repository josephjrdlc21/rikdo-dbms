<?php 
    session_start();
    require_once "db.php";

    if(isset($_SESSION['idaccount_researcher'])){

        $id = $_SESSION['idaccount_researcher'];

    }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../image/rikdologo.png">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <title>
    <?php 
    echo "Create Document";
    ?>
  </title>
    <style>
    *, *::before, *::after{
        box-sizing: border-box;
    }
    body{
        background-color: #f3f3f3;
        margin: 0;
    }
    #container .ql-editor{
        width: 8.5in;
        min-height: 9in;
        padding: 1in;
        margin: 1rem;
        box-shadow: 0 0 5px 0 rgba(0, 0, 0, .5);
        background-color: white;
    }
    #container .ql-container.ql-snow{
        border: none;
        display: flex;
        justify-content: center;
    }
    #container .ql-toolbar.ql-snow{
        display: flex;
        justify-content: center;
        position: sticky;
        top: 0;
        z-index: 1;
        background-color: #f3f3f3;
        border: none;
        box-shadow: 0 0 5px 0 rgba(0, 0, 0, .5);
    }
    .ql-pagebreak {
        border-top: 1px solid #ccc;
        padding: 12px 0;
        border-top-style: dashed;
    }

    @page{
        margin: 1in;
    }
    @media print{
        body{
            background: none;
        }
        #container .ql-editor{
            width: 6.5in;
            padding: 0;
            margin: 0;
            box-shadow: none;
            align-self: flex-start;
        }

        #container .ql-toolbar.ql-snow {
            display: none;
        }

        ::-webkit-scrollbar {
            display: none;
        }
        ::-moz-scrollbar {
            display: none;
        }
        scrollbar {
            display: none;
        }
    }
    </style>
  </head>
  
  <body>
    <div id="container">
        <div id="editor">

        </div>
    </div>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>    
    const toolbarOptions = [  ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],
        [{ 'header': 1 }, { 'header': 2 }],               // custom button values
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
        [{ 'direction': 'rtl' }],                         // text direction

        [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        [{ 'font': [] }],
        [{ 'align': [] }],
        ['clean'],                                         // remove formatting button
        ['link', 'image', 'video'],                       // link and image, video
    ];
    const quill = new Quill('#editor', {
        modules: {
            toolbar: toolbarOptions  
        },
        theme: 'snow'
    });
    </script>   
  </body>
</html>
    
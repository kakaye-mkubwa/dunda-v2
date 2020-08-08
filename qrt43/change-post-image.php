<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../api/vendor/autoload.php';

use FootballBlog\Models\DataHandler;
use FootballBlog\Processors\BloggersFunctions;
use FootballBlog\Processors\SessionManager;
use FootballBlog\Processors\PostsFunctions;

session_start();
if (isset($_SESSION['id'])){
    $sessionID = $_SESSION['id'];

    if ($sessionHandle->checkSessionExists($sessionID) && isset($sessionID)){
        $sessionHandle = new SessionManager();
        $postsFunctions = new PostsFunctions();
        $bloggerFunctions = new BloggersFunctions();
        $dataHandle = new DataHandler();

        if (isset($_GET['id'])){
            $postID = $dataHandle->sanitizeData($_GET['id']);
        }else{
            echo "Failed";
        }

        $bloggerDetails = json_decode($bloggerFunctions->fetchBloggerDetailsAdmin($sessionID),true)['data'][0];

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Editors | Bootstrap Based Admin Template - Material Design</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->

    <!-- Top Bar -->
    <?php include_once 'top_bar.php' ?>
    <!-- #Top Bar -->

    <section>
        <!-- Left Sidebar -->
        <?php include_once 'left_sidebar.php' ?>
        <!-- #END# Left Sidebar -->

        <!-- Right Sidebar -->
        <?php include_once 'right_sidebar.php'?>
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>CHANGE ARTICLE IMAGE</h2>
            </div>


            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                CHANGE POST IMAGE
                            </h2>
                        </div>
                        <div class="body">
                            <form id="add-article-form" enctype="multipart/form-data">
                                <label for="post_image pt-5">Post Image</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="file" id="post_image" name="image" class="form-control" required autofocus>
                                    </div>
                                </div>
                                <input type="hidden" name="blogger" value="<?=$sessionID?>">
                                <input type="hidden" name="post" value="<?=$postID?>">
                            </form>
                            <div id="response-msg">
                            </div>
                        </div>
                        <button id="change-article-image-btn" class="btn btn-block bg-pink waves-effect" type="submit">Change Article Image</button>
                    </div>
                </div>
            </div>
            <!-- #END# CKEditor -->

        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Ckeditor -->
<!--    <script src="plugins/ckeditor/ckeditor.js"></script>-->

    <!-- TinyMCE -->
<!--    <script src="plugins/tinymce/tinymce.js"></script>-->

    <!-- Validation Plugin Js -->
    <script src="plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
<!--    <script src="js/pages/forms/editors.js"></script>-->



    <!-- Demo Js -->
    <script src="js/demo.js"></script>

    <script>
        $(document).ready(function () {
            $('#change-article-image-btn').on('click',function (e) {
                e.preventDefault();

                // console.log($('#hidden-post-content').val());
                $.ajax({
                    url: 'ajax/change-post-image-aj.php',
                    type: 'POST',
                    data: new FormData($('form')[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (responseData) {
                        $('#response-msg').html(responseData);
                    },
                    fail: function () {
                        $('#response-msg').html();
                    }
                });
            });
        });
    </script>
</body>

</html>
    <?php
    }else{
        //Redirect to login page
        header("Location: sign-in.html");
    }
}else{
    //Redirect to login page
    header("Location: sign-in.html");
}
?>

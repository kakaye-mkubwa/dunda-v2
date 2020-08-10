<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../api/vendor/autoload.php';

use FootballBlog\Processors\BloggersFunctions;
use FootballBlog\Processors\SessionManager;
use FootballBlog\Processors\PostsFunctions;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;

session_start();
if (isset($_SESSION['id'])){
    $sessionID = $_SESSION['id'];

    $sessionHandle = new SessionManager();
    $postsFunctions = new PostsFunctions();
    $bloggerFunctions = new BloggersFunctions();

    if ($sessionHandle->checkSessionExists($sessionID) && isset($sessionID)){
        if(isset($_GET["page"])){
            $currentPage = $_GET["page"];
        }else{
            $currentPage = 1;
        }

        $outputCategories = json_decode($postsFunctions->fetchCategories(),true);
        $bloggerPosts = json_decode($postsFunctions->fetchPostsByBloggerAdmin($sessionID),true)['data'];
        $allPosts = json_decode($postsFunctions->fetchAllPublishedPostsMain(),true)['data'];

        $bloggerDetails = json_decode($bloggerFunctions->fetchBloggerDetailsAdmin($sessionID),true)['data'][0];
        $numBloggerTotalPosts = $postsFunctions->countTotalBloggerPosts($sessionID);

        /**
         * pagination
         */
        $adapter = new ArrayAdapter($allPosts);
        $pagerfanta = new Pagerfanta($adapter);

        //set current page
        $pagerfanta->setCurrentPage($currentPage);
        $pagerfanta->getCurrentPage();

        // By default, this will return up to 10 items for the first page of results
        $currentPageResults = $pagerfanta->getCurrentPageResults();

    }

    ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Profile | Bootstrap Based Admin Template - Material Design</title>
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

    <!--  Confirm CDN stylesheet  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
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
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-3">
                    <div class="card profile-card">
                        <div class="profile-header">&nbsp;</div>
                        <div class="profile-body">
                            <div class="image-area">
<!--                                <img src="images/user-lg.jpg" alt="AdminBSB - Profile Image" />-->
                                <img src="<?=$bloggerDetails['image_url']?>" width="64" height="64" alt="AdminBSB - Profile Image" />
                            </div>
                            <div class="content-area">
                                <h3><?=$bloggerDetails['first_name'].' '.$bloggerDetails['last_name']?></h3>
                                <p><?=$bloggerDetails['email']?></p>
                                <p><?=$bloggerDetails['username']?></p>
                            </div>
                        </div>
                        <div class="profile-footer">
                            <ul>
                                <li>
                                    <span>Posts</span>
                                    <span><?=$numBloggerTotalPosts["message"]?></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card card-about-me">
                        <div class="header">
                            <h2>ABOUT ME</h2>
                        </div>
                        <div class="body">
                            <ul>
                                <li>
                                    <div class="title">
                                        <i class="material-icons">library_books</i>
                                        Bio
                                    </div>
                                    <div class="content">
                                        <?=$bloggerDetails['description']?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-9">
                    <div class="card">
                        <div class="body">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="home">
                                        <?php
                                        foreach ($currentPageResults as $post){
                                            $postBlogger = json_decode($bloggerFunctions->fetchBloggerDetailsAdmin($post['author_id']),true)['data'][0];
                                            ?>
                                            <div class="panel panel-default panel-post">
                                                <div class="panel-heading">
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <a href="#">
                                                                <!--                                                            <img src="images/user-lg.jpg" />-->
                                                                <img src="<?=$postBlogger['image_url']?>"/>
                                                            </a>
                                                        </div>
                                                        <div class="media-body">
                                                            <h4 class="media-heading">
                                                                <a href="manage-posts.php"><?=$postBlogger['first_name'].' '.$postBlogger['last_name']?></a>
                                                            </h4>
                                                            Posted - <?=$post['post_date']?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="post">
                                                        <div class="post-heading">
                                                            <a href="">
                                                                <p><?=$post['post_title']?></p>
                                                            </a>
                                                        </div>
                                                        <div class="post-content">
<!--                                                            <img src="images/profile-post-image.jpg" class="img-responsive" />-->
                                                            <img src="<?=$post['image_url']?>" class="img-responsive" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-footer">
                                                    <span id="<?=$post['post_id']?>" class="glyphicon glyphicon-upload m-l-5"></span> Publish
                                                    <span id="<?=$post['post_id']?>" class="glyphicon glyphicon-minus m-l-5"></span> Unpublish
                                                    <span id="<?=$post['post_id']?>" class="glyphicon glyphicon-plus m-l-5"></span> Trend
                                                    <span id="<?=$post['post_id']?>" class="glyphicon glyphicon-remove-sign m-l-5"></span> Untrend
                                                </div>
                                            </div>
                                            <?php
                                        }

                                        if ($pagerfanta->haveToPaginate()){
                                            ?>
                                            <nav>
                                                <ul class="pagination">
                                                    <li class="disabled">
                                                        <a href="javascript:void(0);">
                                                            <i class="material-icons">chevron_left</i>
                                                        </a>
                                                    </li>
                                                    <?php
                                                    for ($i = 1;$i < $pagerfanta->getNbPages() + 1;$i++){
                                                        if ($i == $pagerfanta->getCurrentPage()){
                                                            ?>
                                                            <li class="active"><a href="<?="brakkrab.php?page=".$i?>"><?=$i?></a></li>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <li><a href="<?="brakkrab.php?page=".$i?>" class="waves-effect"><?=$i?></a></li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <li>
                                                        <a href="javascript:void(0);" class="waves-effect">
                                                            <i class="material-icons">chevron_right</i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                            <?php
                                        }
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


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

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/examples/profile.js"></script>

    <!--Confirm CDN-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
    <script>
        $(document).ready(function () {
            $(".glyphicon-upload").on('click',function () {
                var id = $(this).attr('id');
                $.confirm({
                    title: 'Publish',
                    content: 'Publish this post?',
                    type: 'green',
                    alignMiddle:true,
                    theme:'supervan',
                    buttons: {
                        ok: {
                            text: "Yes!",
                            btnClass: 'btn-primary',
                            keys: ['enter'],
                            action: function(){
                                $.ajax({
                                    url:'ajax/publish-post-aj.php',
                                    type:'POST',
                                    data:{id:id}
                                }).done(function (data) {
                                    $.alert(data);
                                }).fail(function(xhr,status){
                                    $.alert('Oops something went wrong');
                                })
                            }
                        },
                        cancel: function(){

                        }
                    }
                });
            });
            $(".glyphicon-minus").on('click',function () {
                var id = $(this).attr('id');
                $.confirm({
                    title: 'Unpublish',
                    content: 'Unpublish this post?',
                    type: 'green',
                    alignMiddle:true,
                    theme:'supervan',
                    buttons: {
                        ok: {
                            text: "Yes!",
                            btnClass: 'btn-primary',
                            keys: ['enter'],
                            action: function(){
                                $.ajax({
                                    url:'ajax/unpublish-post-aj.php',
                                    type:'POST',
                                    data:{id:id}
                                }).done(function (data) {
                                    $.alert(data);
                                }).fail(function(xhr,status){
                                    $.alert('Oops something went wrong');
                                })
                            }
                        },
                        cancel: function(){

                        }
                    }
                });
            });


            $(".glyphicon-plus").on('click',function (){
                var id = $(this).attr('id');
                $.confirm({
                    title: 'Trend',
                    content: 'Trend this post?',
                    type: 'green',
                    alignMiddle:true,
                    theme:'supervan',
                    buttons: {
                        ok: {
                            text: "Yes!",
                            btnClass: 'btn-primary',
                            keys: ['enter'],
                            action: function(){
                                $.ajax({
                                    url:'ajax/trend-post-aj.php',
                                    type:'POST',
                                    data:{id:id}
                                }).done(function (data) {
                                    $.alert(data);
                                }).fail(function(xhr,status){
                                    $.alert('Oops something went wrong');
                                })
                            }
                        },
                        cancel: function(){

                        }
                    }
                });
            });

            $(".glyphicon-remove-sign").on('click',function (){
                var id = $(this).attr('id');
                $.confirm({
                    title: 'Untrend',
                    content: 'Untrend this post?',
                    type: 'green',
                    alignMiddle:true,
                    theme:'supervan',
                    buttons: {
                        ok: {
                            text: "Yes!",
                            btnClass: 'btn-primary',
                            keys: ['enter'],
                            action: function(){
                                $.ajax({
                                    url:'ajax/untrend-post-aj.php',
                                    type:'POST',
                                    data:{id:id}
                                }).done(function (data) {
                                    $.alert(data);
                                }).fail(function(xhr,status){
                                    $.alert('Oops something went wrong');
                                })
                            }
                        },
                        cancel: function(){

                        }
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
?>

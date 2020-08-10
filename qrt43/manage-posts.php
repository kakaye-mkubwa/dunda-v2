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

        $bloggerDetails = json_decode($bloggerFunctions->fetchBloggerDetailsAdmin($sessionID),true)['data'][0];
        $numBloggerTotalPosts = $postsFunctions->countTotalBloggerPosts($sessionID);

        /**
         * pagination
         */
        $adapter = new ArrayAdapter($bloggerPosts);
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
    <title>Profile | Dunda Football</title>
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
                                    <li role="presentation"><a href="#profile_settings" aria-controls="settings" role="tab" data-toggle="tab">Profile Settings</a></li>
                                    <li role="presentation"><a href="#change_profile_image_settings" aria-controls="settings" role="tab" data-toggle="tab">Change Profile Image</a></li>
                                    <li role="presentation"><a href="#change_password_settings" aria-controls="settings" role="tab" data-toggle="tab">Change Password</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="home">
                                        <?php
                                        foreach ($bloggerPosts as $post){
                                            $url = $postsFunctions->newsUrlGenerator($post['post_date'],$post['url_slug']);
                                            ?>
                                            <div class="panel panel-default panel-post">
                                                <div class="panel-heading">
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <a href="#">
                                                                <!--                                                            <img src="images/user-lg.jpg" />-->
                                                                <img src="<?=$bloggerDetails['image_url']?>"/>
                                                            </a>
                                                        </div>
                                                        <div class="media-body">
                                                            <h4 class="media-heading">
                                                                <a href="manage-posts.php"><?=$bloggerDetails['first_name'].' '.$bloggerDetails['last_name']?></a>
                                                            </h4>
                                                            Posted - <?=$post['post_date']?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="post">
                                                        <div class="post-heading">
                                                            <a href="<?='../'.$url?>">
                                                                <p><?=$post['post_title']?></p>
                                                            </a>
                                                        </div>
                                                        <div class="post-content">
                                                            <img src="<?=$post['image_url']?>" class="img-responsive" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-footer">
                                                    <span id="<?=$post['post_id']?>" class="glyphicon glyphicon-trash m-l-5"></span> Delete
                                                    <span id="<?=$post['post_id']?>" class="glyphicon glyphicon-edit m-l-5"></span> Edit
                                                    <span id="<?=$post['post_id']?>" class="glyphicon glyphicon-upload m-l-5"></span> Publish
                                                    <span id="<?=$post['post_id']?>" class="glyphicon glyphicon-minus m-l-5"></span> Unpublish
                                                    <span id="<?=$post['post_id']?>" class="glyphicon glyphicon-plus m-l-5" data-toggle="modal" data-target="#staticModal"></span> Add Tags
                                                    <span id="<?=$post['post_id']?>" class="glyphicon glyphicon-remove-sign m-l-5" data-toggle="modal" data-target="#staticRemoveModal"></span> Remove tags
                                                    <span id="<?=$post['post_id']?>" class="glyphicon glyphicon-camera m-l-5"></span> Edit Image
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
                                                            <li class="active"><a href="<?="manage-posts.php?page=".$i?>"><?=$i?></a></li>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <li><a href="<?="manage-posts.php?page=".$i?>" class="waves-effect"><?=$i?></a></li>
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

                                    <div role="tabpanel" class="tab-pane fade in" id="profile_settings">
                                        <form id="edit-user-details-form" class="form-horizontal" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="first_name" class="col-sm-2 control-label">First Name</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="<?=$bloggerDetails['first_name']?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="last_name" class="col-sm-2 control-label">Last Name</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="<?=$bloggerDetails['last_name']?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="Email" class="col-sm-2 control-label">Email</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <input type="email" class="form-control" id="Email" name="email" placeholder="Email" value="<?=$bloggerDetails['email']?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="username" class="col-sm-2 control-label">Username</label>

                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?=$bloggerDetails['username']?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="bio" class="col-sm-2 control-label">Bio</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <textarea class="form-control" id="bio" name="description" rows="3" placeholder="Bio..." required><?=$bloggerDetails['description']?></textarea>
                                                    </div>
                                                </div>
                                            </div>

<!--                                            <div class="form-group">-->
<!--                                                <div class="col-sm-offset-2 col-sm-10">-->
<!--                                                    <input type="checkbox" id="terms_condition_check" class="chk-col-red filled-in" />-->
<!--                                                    <label for="terms_condition_check">I agree to the <a href="#">terms and conditions</a></label>-->
<!--                                                </div>-->
<!--                                            </div>-->
                                            <input type="hidden" name="blogger" value="<?=$sessionID?>">
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button id="edit-user-details-btn" type="submit" class="btn btn-danger">SUBMIT</button>
                                                </div>
                                            </div>
                                            <div id="edit-user-details-form-response-msg">
                                            </div>
                                        </form>
                                    </div>

                                    <div role="tabpanel" class="tab-pane fade in" id="change_profile_image_settings">
                                        <form id="change-profile-image-form" class="form-horizontal" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="profile-image" class="col-sm-3 control-label">New Profile Picture</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="file" class="form-control" id="profile-image" name="image" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="blogger" value="<?=$sessionID?>">

                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9">
                                                    <button id="change-profile-image-btn" type="submit" class="btn btn-danger">SUBMIT</button>
                                                </div>
                                            </div>
                                            <div id="change-profile-image-response-msg">

                                            </div>
                                        </form>
                                    </div>

                                    <div role="tabpanel" class="tab-pane fade in" id="change_password_settings">
                                        <form id="change-password-form" class="form-horizontal" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="OldPassword" class="col-sm-3 control-label">Old Password</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" id="old-password" name="old_password" placeholder="Old Password" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="NewPassword" class="col-sm-3 control-label">New Password</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" id="new-password" name="new_password" placeholder="New Password" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="NewPasswordConfirm" class="col-sm-3 control-label">New Password (Confirm)</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" id="new-password-confirm" name="new_password_confirm" placeholder="New Password (Confirm)" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="blogger" value="<?=$sessionID?>">

                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9">
                                                    <button id="change-password-btn" type="submit" class="btn btn-danger">SUBMIT</button>
                                                </div>
                                            </div>
                                            <div id="change-password-response-msg">

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>


    <!--  Remove tag modal  -->
    <div class="modal fade" id="staticRemoveModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Remove Tags</h4>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <label for="removeTagInput">Tag</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="removeTagInput" class="form-control" placeholder="Enter tag">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm" id="submit-remove-tag-button">
                        <i class="fa fa-dot-circle-o"></i> Submit
                    </button>
                    <button type="reset" class="btn btn-danger btn-sm" data-dismiss="modal">
                        <i class="fa fa-ban"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--  Remove tag modal  -->

    <!-- add tag modal static -->
    <div class="modal fade" id="staticModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Add Tags</h4>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <label for="tagInput">Tag</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="tagInput" class="form-control" placeholder="Enter tag">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm" id="submit-add-tag-button">
                        <i class="fa fa-dot-circle-o"></i> Submit
                    </button>
                    <button type="reset" class="btn btn-danger btn-sm" data-dismiss="modal">
                        <i class="fa fa-ban"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- add tag modal static -->

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
            $(".glyphicon-trash").on('click',function () {
                var id = $(this).attr('id');
                console.log("Delete clicked "+ id);
                $.confirm({
                    title: 'Delete',
                    content: 'Proceed to delete?',
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
                                    url:'ajax/delete-post-aj.php',
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
            $(".glyphicon-edit").on('click',function () {
                var id = $(this).attr('id');
                var user = $("#user").text();
                window.location.href=("edit-post.php?id="+id+"&user="+user);
            });
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

            $(".glyphicon-camera").on('click',function () {
                var id = $(this).attr('id');
                var user = $("#user").text();
                window.location.href=("change-post-image.php?id="+id);
            });

            let postID = null;
            $(".glyphicon-plus").on('click',function (){
                postID = $(this).attr('id');
            });
            $(".glyphicon-remove-sign").on('click',function (){
                postID = $(this).attr('id');
            });
            $("#submit-add-tag-button").on('click',function () {
                var tag = $('#tagInput').val();
                var id = postID;

                console.log(id);
                $.ajax({
                    url:'ajax/add-posts-tag-aj.php',
                    type:'POST',
                    data:{tag:tag,id:id}
                }).done(function (data) {
                    $.alert(data);
                }).fail(function(xhr,status){
                    $.alert('Oops something went wrong');
                })
            });
            $("#submit-remove-tag-button").on('click',function() {
                var tag = $('#removeTagInput').val();
                var id = postID;

                console.log(id);
                $.ajax({
                    url:'ajax/delete-posts-tag-aj.php',
                    type:'POST',
                    data:{tag:tag,id:id}
                }).done(function (data) {
                    $.alert(data);
                }).fail(function(xhr,status){
                    $.alert('Oops something went wrong');
                })
            });

            $('#edit-user-details-btn').on('click', function (e) {
                e.preventDefault();

                $.ajax({
                    url: 'ajax/edit-user-details-aj.php',
                    type: 'POST',
                    data: new FormData(document.getElementById("edit-user-details-form")),
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (responseData) {
                        $('#edit-user-details-form-response-msg').html(responseData);
                    },
                    fail: function () {
                        $('#edit-user-details-form-response-msg').html();
                    }
                });
            });

            $('#change-password-btn').on('click', function (e) {
                e.preventDefault();

                $.ajax({
                    url: 'ajax/change-password-aj.php',
                    type: 'POST',
                    data: new FormData(document.getElementById("change-password-form")),
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (responseData) {
                        $('#change-password-response-msg').html(responseData);
                    },
                    fail: function () {
                        $('#change-password-response-msg').html();
                    }
                });
            });

            $('#change-profile-image-btn').on('click', function (e) {
                e.preventDefault();

                $.ajax({
                    url: 'ajax/change-profile-image-aj.php',
                    type: 'POST',
                    data: new FormData(document.getElementById("change-profile-image-form")),
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (responseData) {
                        $('#change-profile-image-response-msg').html(responseData);
                    },
                    fail: function () {
                        $('#change-profile-image-response-msg').html();
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

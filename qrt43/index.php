<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../api/vendor/autoload.php';

use FootballBlog\Processors\BloggersFunctions;
use FootballBlog\Processors\SessionManager;
use FootballBlog\Processors\PostsFunctions;

session_start();

if (isset($_SESSION['id'])){
    $sessionID = $_SESSION['id'];

    $sessionHandle = new SessionManager();
    $postsFunctions = new PostsFunctions();
    $bloggerFunctions = new BloggersFunctions();


    if ($sessionHandle->checkSessionExists($sessionID) && isset($sessionID)){
        $weekTopBloggers = $postsFunctions->weekTopBloggersList()['message'];
        $monthTopBloggers = $postsFunctions->monthTopBloggersList()['message'];
        $yearTopBloggers = $postsFunctions->yearTopBloggersList()['message'];

        $numBloggerWeekPosts = $postsFunctions->countWeekBloggerPosts($sessionID);
        $numBloggerMonthPosts = $postsFunctions->countMonthBloggerPosts($sessionID);
        $numBloggerYearPosts = $postsFunctions->countYearBloggerPosts($sessionID);
        $numBloggerTotalPosts = $postsFunctions->countTotalBloggerPosts($sessionID);

        $bloggerDetails = json_decode($bloggerFunctions->fetchBloggerDetailsAdmin($sessionID),true)['data'][0];

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Welcome To | Dunda Football - Admin Panel</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="plugins/morrisjs/morris.css" rel="stylesheet" />

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
                <h2>DASHBOARD</h2><br><br>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box hover-expand-effect">
                        <div class="icon bg-teal">
                            <i class="material-icons">equalizer</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL POSTS</div>
                            <div class="number"><?=$numBloggerTotalPosts["message"]?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box hover-expand-effect">
                        <div class="icon bg-teal">
                            <i class="material-icons">equalizer</i>
                        </div>
                        <div class="content">
                            <div class="text">WEEK POSTS</div>
                            <div class="number"><?=$numBloggerWeekPosts["message"]?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box hover-expand-effect">
                        <div class="icon bg-teal">
                            <i class="material-icons">equalizer</i>
                        </div>
                        <div class="content">
                            <div class="text">MONTH POSTS</div>
                            <div class="number"><?=$numBloggerMonthPosts["message"]?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box hover-expand-effect">
                        <div class="icon bg-teal">
                            <i class="material-icons">equalizer</i>
                        </div>
                        <div class="content">
                            <div class="text">YEAR POSTS</div>
                            <div class="number"><?=$numBloggerYearPosts["message"]?></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->

            <!-- Striped Rows -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                TOP WRITERS (WEEK)
                                <small>Use <code>.table-striped</code> to add zebra-striping to any table row within the <code>&lt;tbody&gt;</code></small>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>FIRST NAME</th>
                                    <th>LAST NAME</th>
                                    <th>POSTS</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($weekTopBloggers as $blogger){
                                    ?>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td><?=$blogger['first_name']?></td>
                                        <td><?=$blogger['last_name']?></td>
                                        <td><?=$blogger['num_posts']?></td>
                                    </tr>
                                    <?php
                                }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Striped Rows -->

            <!-- Striped Rows -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                TOP WRITERS (MONTH)
                                <small>Use <code>.table-striped</code> to add zebra-striping to any table row within the <code>&lt;tbody&gt;</code></small>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>FIRST NAME</th>
                                    <th>LAST NAME</th>
                                    <th>POSTS</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($monthTopBloggers as $blogger){
                                    ?>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td><?=$blogger['first_name']?></td>
                                        <td><?=$blogger['last_name']?></td>
                                        <td><?=$blogger['num_posts']?></td>
                                    </tr>
                                    <?php
                                }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Striped Rows -->

            <!-- Striped Rows -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                TOP WRITERS (YEAR)
                                <small>Use <code>.table-striped</code> to add zebra-striping to any table row within the <code>&lt;tbody&gt;</code></small>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>FIRST NAME</th>
                                    <th>LAST NAME</th>
                                    <th>POSTS</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($yearTopBloggers as $blogger){
                                    ?>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td><?=$blogger['first_name']?></td>
                                        <td><?=$blogger['last_name']?></td>
                                        <td><?=$blogger['num_posts']?></td>
                                    </tr>
                                    <?php
                                }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Striped Rows -->

            <div class="row clearfix">

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

    <!-- Jquery CountTo Plugin Js -->
    <script src="plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/morrisjs/morris.js"></script>

    <!-- ChartJs -->
    <script src="plugins/chartjs/Chart.bundle.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="plugins/flot-charts/jquery.flot.js"></script>
    <script src="plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="plugins/flot-charts/jquery.flot.time.js"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="plugins/jquery-sparkline/jquery.sparkline.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/index.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
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

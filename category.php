<?php
include_once 'includes/header.php';

if (isset($_GET['category'])) {
    $categoryName = $_GET['category'];

    $allCategories = json_decode($postsFunctions->fetchCategories(),true);
    $categoryPresentFlag = false;

    foreach ($allCategories['data'] as $row){
        if ($categoryName == $row['category_name']){
            $categoryPresentFlag = true;
        }
    }

    if ($categoryPresentFlag){
        $categoryPosts = json_decode($postsFunctions->fetchPostsByCategoryMain($categoryName),true)['data'];

        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <title><?=$categoryName?> - Dunda Football</title>
            <!-- META -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

            <!-- Facebook   -->
            <meta property="og:site_name" content="Dunda Football">
            <meta property="og:title" content="<?=$categoryName?> | Dunda Football" />
            <meta property="og:description" content="<?='Stay up to date with '.$categoryName.' news'?>" />
            <meta property="og:type" content="article" />
            <meta property="og:image" itemprop="image" content="../assets/img/logo/dunda_logo.png">
            <meta property="og:image:width" content="150px">
            <meta property="og:image:height" content="150px">

            <!-- Twitter -->
            <meta property="twitter:card" content="summary_large_image">
            <meta property="twitter:url" content="https://dundafootball.com<?=$request?>">
            <meta property="twitter:title" content="<?=$categoryName?> | Dunda Football">
            <meta property="twitter:description" content="<?='Stay up to date with '.$categoryName.' news'?>">
            <meta property="twitter:image" content="../assets/img/logo/dunda_logo.png">

            <!--::::: FABICON ICON :::::::-->
            <link rel="icon" href="assets/img/icon/fabicon.png">
            <!--::::: ALL CSS FILES :::::::-->
            <link rel="stylesheet" href="../assets/css/plugins/bootstrap.min.css">
            <link rel="stylesheet" href="../assets/css/plugins/animate.min.css">
            <link rel="stylesheet" href="../assets/css/plugins/fontawesome.css">
            <link rel="stylesheet" href="../assets/css/plugins/modal-video.min.css">
            <link rel="stylesheet" href="../assets/css/plugins/owl.carousel.css">
            <link rel="stylesheet" href="../assets/css/plugins/slick.css">
            <link rel="stylesheet" href="../assets/css/plugins/stellarnav.css">
            <link rel="stylesheet" href="../assets/css/theme.css">
        </head>

        <body class="theme-3 theme3_bg">
        <!--::::: PRELOADER START :::::::-->
        <div class="preloader">
            <div>
                <div class="nb-spinner"></div>
            </div>
        </div>
        <!--::::: PRELOADER END :::::::-->

        <!--::::: TOP BAR START :::::::-->
        <div class="topbar white_bg">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 align-self-center">
                        <div class="trancarousel_area">
                            <p class="trand">Trending</p>
                            <div class="trancarousel owl-carousel nav_style1">
                                <?php
                                foreach ($trendingPosts['data'] as $row){
                                    $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                                    ?>
                                    <div class="trancarousel_item">
                                        <p>
                                            <a href="<?='../'.$url?>"><?=$row['post_title']?></a>
                                        </p>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 align-self-center">
                        <div class="top_date_social text-right">
                            <div class="social1">
                                <ul class="inline">
                                    <li><a href="https://twitter.com/DundaFootball"><i class="fab fa-instagram"></i></a>
                                    </li>
                                    <li><a href="https://facebook.com/dundafootball/"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li><a href="https://www.instagram.com/dundafootball/"><i class="fab fa-twitter"></i></a>
                                    </li>
                                </ul>
                            </div>

                            <div class="lang-3">
                                <a href="#">English </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--::::: TOP BAR END :::::::-->

        <div class="border_black"></div>

        <!--::::: LOGO AREA START  :::::::-->
        <div class="logo_area white_bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 align-self-center">
                        <div class="logo">
                            <a href="../home">
                                <img src="../assets/img/logo/dunda400x150.png" alt="Dunda Football">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--::::: LOGO AREA END :::::::-->

        <!--::::: MENU AREA START  :::::::-->
        <div class="container">
            <div class="main-menu">
                <div class="main-nav clearfix is-ts-sticky">
                    <div class="row justify-content-between">
                        <div class="col-4 col-lg-9 align-self-center">
                            <div class="newsprk_nav stellarnav">
                                <ul id="newsprk_menu">
                                    <li><a href="../home">Home </a></li>
                                    <li><a href="#">Categories <i class="fal fa-angle-down"></i></a>
                                        <ul>
                                            <?php
                                            foreach ($outputCategories['data'] as $row){
                                                ?>
                                                <li class="active">
                                                    <a href="<?='../category/'.$row['category_name']?>"><?=$row['category_name']?></a>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>

                                    </li>
                                    <li><a href="../about">About</a></li>
                                    <li><a href="../contact">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-8 col-lg-3 text-right align-self-center">
                            <div class="date3">
                                <p id="today-date"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--::::: MENU AREA END :::::::-->

        <!--::::: ARCHIVE AREA START :::::::-->
        <div class="archives layout3 post post1 padding-top-30">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="bridcrumb">	<a href="../home">Home</a> / Categories / <?=$categoryName?></div>
                    </div>
                </div>
                <div class="space-20"></div>
                <div class="row">
                    <div class="col-md-6 col-lg-8">
                        <div class="row">
                            <div class="col-12">
                                <div class="categories_title">
                                    <h5>Category: <a href="<?=$categoryName?>"><?=$categoryName?></a></h5>
                                </div>
                            </div>
                        </div>
                        <div class="white_bg border-radious5 padding20">

                            <div class="row">
                                <?php
                                foreach ($categoryPosts as $row){
                                    $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                                    ?>
                                    <div class="col-lg-6">
                                        <div class="single_post post_type3 xs-mb90 post_type15">
                                            <div class="post_img border-radious5">
                                                <a href="<?='../'.$url?>">
                                                    <img src="<?='../'.$row['image_url']?>" alt="<?=$row['post_desc']?>">
                                                </a>
                                                <span class="tranding border_tranding">
									            <i class="fas fa-bolt"></i>
								            </span>
                                            </div>
                                            <div class="single_post_text">
                                                <h4><a href="<?='../'.$url?>"><?=$row['post_title']?></a></h4>
                                                <div class="space-10"></div>
                                                <p class="post-p"><?=substr($row['post_content'],0,120)?></p>
                                                <div class="space-20"></div>
                                                <div class="meta3">
                                                    <a href="<?=$row['category']?>"><?=$row['category']?></a>
                                                    <a href="#"><?=$postsFunctions->generatePrettyDate($row['post_date'])?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="follow_box widget sociai_style3 mb30 white_bg padding20 white_bg border-radious5 inner_socail4">
                            <h2 class="widget-title">Contact Us</h2>
                            <div class="social_shares">
                                <a class="single_social social_facebook" href="#">	<span class="follow_icon"><i class="fab fa-facebook-f"></i></span>
                                    34,456 <span class="icon_text">Fans</span>
                                </a>
                                <a class="single_social social_twitter" href="#">	<span class="follow_icon"><i class="fab fa-twitter"></i></span>
                                    34,456 <span class="icon_text">Followers</span>
                                </a>
                                <a class="single_social social_instagram" href="#">	<span class="follow_icon"><i class="fab fa-instagram"></i></span>
                                    34,456 <span class="icon_text">Followers</span>
                                </a>
                            </div>
                        </div>
                        <div class="trending_widget white_bg mb30 padding20 border-radious5">
                            <h2 class="widget-title">Trending News</h2>
                            <?php
                            $trendingPostsTrim = $postsFunctions->arrayTrimContent($trendingPosts['data'],3);
                            foreach ($trendingPostsTrim as $row){
                                $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                                ?>
                                <div class="single_post post_type3 mb30 xs-mb90 post_type15">
                                    <div class="post_img border-radious5">
                                        <a href="<?='../'.$url?>">
                                            <img src="<?='../'.$row['image_url']?>" alt="<?=$row['post_desc']?>">
                                        </a>
                                        <span class="tranding border_tranding">
										    <i class="fas fa-bolt"></i>
									    </span>
                                    </div>
                                    <div class="single_post_text">
                                        <h4><a href="<?='../'.$url?>"><?=$row['post_title']?></a></h4>
                                        <div class="space-10"></div>
                                        <p class="post-p"><?=substr($row['post_content'],0,120)?></p>
                                        <div class="space-20"></div>
                                        <div class="meta3">	<a href="<?=$row['category']?>"><?=$row['category']?></a>
                                            <a href="#"><?=$postsFunctions->generatePrettyDate($row['post_date'])?></a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="banner2 mb30">
                            <?php
                            foreach ($recentPostsOutput30Days['data'] as $row){
                                $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                                ?>
                                <a href="<?='../'.$url?>">
                                    <img class="border-radious5" src="<?='../'.$row['image_url']?>" alt="<?=$row['post_desc']?>">
                                </a>
                                <?php
                                break;
                            }
                            ?>
                        </div>
                        <div class="most_widget3 white_bg mb30 padding20 border-radious5">
                            <div class="heading">
                                <h2 class="widget-title">Most View</h2>
                            </div>
                            <div class="popular_carousel owl-carousel nav_style1">
                                <!--CAROUSEL START-->
                                <div class="popular_items">
                                    <?php
                                    $row = $recentPostsShuffle = $postsFunctions->shufflePublishedPostsAssoc($recentPostsOutput30Days['data']);
                                    for ($i = 0;$i < 5;$i++){
                                        $url = $postsFunctions->newsUrlGenerator($row[$i]['post_date'],$row[$i]['url_slug']);
                                        ?>
                                        <div class="single_post type10 type16 widgets_small mb15">
                                            <div class="post_img">
                                                <a href="<?='../'.$url?>">
                                                    <img src="<?='../'.$row[$i]['image_url']?>" alt="<?=$row[$i]['post_desc']?>">
                                                </a>
                                            </div>
                                            <div class="single_post_text">
                                                <h4><a href="<?='../'.$url?>"><?=$row[$i]['post_title']?></a></h4>
                                                <div class="meta4">	<a href="<?=$row[$i]['category']?>"><?=$row[$i]['category']?></a>
                                                </div>
                                                <div class="space-5"></div>
                                                <div class="border_black"></div>
                                                <div class="space-15"></div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="popular_items">
                                    <?php
                                    for ($i = 5;$i < 10;$i++){
                                        $url = $postsFunctions->newsUrlGenerator($row[$i]['post_date'],$row[$i]['url_slug']);
                                        ?>
                                        <div class="single_post type10 type16 widgets_small mb15">
                                            <div class="post_img">
                                                <a href="<?='../'.$url?>">
                                                    <img src="<?='../'.$row[$i]['image_url']?>" alt="<?=$row[$i]['post_desc']?>">
                                                </a>
                                            </div>
                                            <div class="single_post_text">
                                                <h4><a href="<?='../'.$url?>"><?=$row[$i]['post_title']?></a></h4>
                                                <div class="meta4">	<a href="<?=$row[$i]['category']?>"><?=$row[$i]['category']?></a>
                                                </div>
                                                <div class="space-5"></div>
                                                <div class="border_black"></div>
                                                <div class="space-15"></div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <!--CAROUSEL END-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--::::: ARCHIVE AREA END :::::::-->

        <!--::::: FOOTER AREA START :::::::-->
        <?php include_once 'includes/tag_footer_area.php'?>
        <!--::::: FOOTER AREA END :::::::-->

        <!--::::: ALL JS FILES :::::::-->
        <script src="../assets/js/plugins/jquery.2.1.0.min.js"></script>
        <script src="../assets/js/plugins/bootstrap.min.js"></script>
        <script src="../assets/js/plugins/jquery.nav.js"></script>
        <script src="../assets/js/plugins/jquery.waypoints.min.js"></script>
        <script src="../assets/js/plugins/jquery-modal-video.min.js"></script>
        <script src="../assets/js/plugins/owl.carousel.js"></script>
        <script src="../assets/js/plugins/popper.min.js"></script>
        <script src="../assets/js/plugins/stellarnav.js"></script>
        <script src="../assets/js/plugins/circle-progress.js"></script>
        <script src="../assets/js/plugins/wow.min.js"></script>
        <script src="../assets/js/plugins/slick.min.js"></script>
        <script src="../assets/js/main.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sharer.js@latest/sharer.min.js"></script>
        <script>
            var today = new Date();
            var months=["January","February","March","April","May","June","July","August","September","October","November","December"];
            var fullDate = months[today.getMonth()]+" "+today.getDate() +", "+today.getFullYear();
            $("#today-date").text(fullDate);
        </script>

        </body>

        </html>
        <?php
    }else{

        ?>
        <script>window.location.href = '../page-not-found';</script>
        <?php
    }
}else{
    ?>
    <script>window.location.href = '../page-not-found';</script>
    <?php
}
?>

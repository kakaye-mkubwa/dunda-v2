<?php
include_once 'includes/header.php';

if (isset($_GET['date']) && isset($_GET['time']) && isset($_GET['slug'])){
    $date = $_GET['date'];
    $slug = $_GET['slug'];
    $time = $_GET['time'];

    $request = htmlentities($_SERVER['REQUEST_URI']);

    $fullDateTime = strtotime($date.$time);

    $newformattedDate = date('Y-m-d H:i:s',$fullDateTime);

    $dateSlugPosts = json_decode($postsFunctions->fetchPostDetailsByDateAndSlug($newformattedDate,$slug),true);

    if (isset($dateSlugPosts['data'])){
        $postDetails = $dateSlugPosts['data'][0];
        $bloggerDetails = json_decode($bloggerFunctions->fetchBloggerDetails($postDetails['author_id']),true)['data'][0];
        $tagsArray = $postsFunctions->fetchBlogTags($postDetails['post_id']);
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <title><?=$postDetails['post_title']?> - Dunda Football</title>
            <!-- META -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


            <!-- Facebook   -->
            <meta property="og:site_name" content="Dunda Football">
            <meta property="og:title" content="<?=$postDetails['post_title']?>" />
            <meta property="og:description" content="<?=$postDetails['post_desc']?>" />
            <meta property="og:image" itemprop="image" content="<?=$postDetails['image_url']?>">
            <meta property="og:image:width" content="150px">
            <meta property="og:image:height" content="150px">
            <meta property="og:type" content="article" />

            <!-- Twitter -->
            <meta property="twitter:card" content="summary_large_image">
            <meta property="twitter:url" content="https://dundafootball.com<?=$request?>">
            <meta property="twitter:title" content="<?=$postDetails['post_title']?>">
            <meta property="twitter:description" content="<?=$postDetails['post_desc']?>">
            <meta property="twitter:image" content="<?=$postDetails['image_url']?>">

            <!--::::: FABICON ICON :::::::-->
            <link rel="icon" href="assets/img/icon/fabicon.png">
            <!--::::: ALL CSS FILES :::::::-->
            <link rel="stylesheet" href="../../../assets/css/plugins/bootstrap.min.css">
            <link rel="stylesheet" href="../../../assets/css/plugins/animate.min.css">
            <link rel="stylesheet" href="../../../assets/css/plugins/fontawesome.css">
            <link rel="stylesheet" href="../../../assets/css/plugins/modal-video.min.css">
            <link rel="stylesheet" href="../../../assets/css/plugins/owl.carousel.css">
            <link rel="stylesheet" href="../../../assets/css/plugins/slick.css">
            <link rel="stylesheet" href="../../../assets/css/plugins/stellarnav.css">
            <link rel="stylesheet" href="../../../assets/css/theme.css">
        </head>

        <body class="theme-3">
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
                                        <p><a href="<?='../../../'.$url?>"><?=$row['post_title']?></a>
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

                            <div class="lang-3">	<a href="#">English </a>
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
                            <a href="../../../home">
                                <img src="../../../assets/img/logo/dunda_logo.png" alt="Dunda Football">
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
                                    <li><a href="../../../home">Home </a></li>
                                    <li><a href="#">Categories <i class="fal fa-angle-down"></i></a>
                                        <ul>
                                            <?php
                                            foreach ($outputCategories['data'] as $row){
                                                ?>
                                                <li class="active">
                                                    <a href="<?='../../../category/'.$row['category_name']?>"><?=$row['category_name']?></a>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>

                                    </li>
                                    <li><a href="../../../about">About</a></li>
                                    <li><a href="../../../contact">Contact</a></li>
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
                        <div class="bridcrumb">	<a href="../../../home">Home</a> / News/ <?=$postDetails['post_title']?></div>
                    </div>
                </div>
                <div class="space-30"></div>
                <div class="row">
                    <div class="col-md-6 col-lg-8">
                        <div class="row">
                            <div class="col-4 align-self-center">
                                <div class="page_category">
                                    <h4><?=$postDetails['category']?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="space-30"></div>
                        <div class="single_post_heading">
                            <h1><?=$postDetails['post_title']?></h1>
                            <div class="space-10"></div>
                            <!--                        <p>The property, complete with 30-seat screening from room, a 100-seat amphitheater and a swimming pond with sandy shower…</p>-->
                        </div>
                        <div class="space-40"></div>
                        <img class="border-radious5" src="<?=$postDetails['image_url']?>" alt="image">
                        <!--                    <img class="border-radious5" src="assets/img/blog/single_post1.jpg" alt="image">-->
                        <div class="space-20"></div>
                        <div class="row">
                            <div class="col-lg-6 align-self-center">
                                <div class="author">
                                    <div class="author_img">
                                        <div class="author_img_wrap">
                                            <img src="assets/img/author/author2.png" alt="<?=$bloggerDetails['first_name'].' '.$bloggerDetails['last_name']?>" - Dunda Football>
                                        </div>
                                    </div>	<a href="#"><?=$bloggerDetails['first_name'].' '.$bloggerDetails['last_name']?></a>
                                    <ul>
                                        <li><a href="#"><?=$postsFunctions->generatePrettyDate($postDetails['post_date'])?></a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 align-self-center">
                                <div class="author_social inline text-right">
                                    <ul>
                                        <li>
                                            <a href="#" id="share-wa" class="sharer button" data-sharer="whatsapp" data-title="<?=$postDetails['post_title']?>" data-url="https://dundafootball.com<?=$request?>" data-web="Share on Whatsapp Web">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" id="share-tw" class="sharer button" data-sharer="twitter" data-title="<?=$postDetails['post_title']?>" data-hashtags="dundafootball" data-url="https://dundafootball.com<?=$request?>">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" id="share-fb" class="sharer button" data-sharer="facebook" data-hashtag="dundafootball" data-url="https://dundafootball.com<?=$request?>">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li>
<!--                                            <a href="#" data-sharer="telegram" data-title="--><?//=$postDetails['post_title']?><!--" data-url="https://dundafootball.com--><?//=$request?><!--" data-to="+44555-5555">-->
                                            <a href="#" data-sharer="telegram" data-title="<?=$postDetails['post_title']?>" data-url="https://dundafootball.com<?=$request?>">
                                                <i class="fab fa-telegram"></i>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="space-20"></div>

                        <!-- POST SECTION -->
                        <div>
                            <?=$postDetails['post_content']?>
                        </div>
                        <!-- END POST SECTION-->
                        <div class="space-40"></div>
                        <div class="tags">
                            <ul class="inline">
                                <li class="tag_list"><i class="fas fa-tag"></i> tags</li>
                                <?php
                                foreach ($tagsArray as $tag){
                                    ?>
                                    <li>
                                        <a href="<?='../../../tag/'.$tag['tagName']?>"><?=$tag['tagName']?></a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="space-40"></div>
                        <div class="border_black"></div>
                        <div class="space-40"></div>
                        <div class="next_prev">
                            <div class="row">
                                <div class="col-lg-6 align-self-center">
                                    <div class="next_prv_single border_left3">
                                        <?php
                                        $recentPostsOutput30DaysShuffle = $postsFunctions->shufflePublishedPostsAssoc($recentPostsOutput30Days['data']);
                                        foreach ($recentPostsOutput30DaysShuffle as $row){
                                            $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                                            ?>
                                            <p>PREVIOUS NEWS</p>
                                            <h3><a href="<?='../../../'.$url?>"><?=$row['post_title']?></a></h3>
                                            <?php
                                            break;
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-lg-6 align-self-center">
                                    <div class="next_prv_single border_left3">
                                        <?php
                                        $recentPostsOutput30DaysShuffle = $postsFunctions->shufflePublishedPostsAssoc($recentPostsOutput30Days['data']);
                                        foreach ($recentPostsOutput30DaysShuffle as $row){
                                            $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                                            ?>
                                            <p>NEXT NEWS</p>
                                            <h3><a href="<?='../../../'.$url?>"><?=$row['post_title']?></a></h3>
                                            <?php
                                            break;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="follow_box widget sociai_style3 mb30 white_bg padding20 white_bg border-radious5 inner_socail4">
                            <h2 class="widget-title">Contact Us</h2>
                            <div class="social_shares">
                                <a class="single_social social_facebook" href="https://facebook.com/dundafootball/">	<span class="follow_icon"><i class="fab fa-facebook-f"></i></span>
                                    1,377 <span class="icon_text">Fans</span>
                                </a>
                                <a class="single_social social_twitter" href="https://twitter.com/DundaFootball">	<span class="follow_icon"><i class="fab fa-twitter"></i></span>
                                    200 <span class="icon_text">Followers</span>
                                </a>
                                <a class="single_social social_instagram" href="https://www.instagram.com/dundafootball/">	<span class="follow_icon"><i class="fab fa-instagram"></i></span>
                                    108 <span class="icon_text">Followers</span>
                                </a>
                            </div>
                        </div>
                        <!--:::::: POST TYPE 3 START :::::::-->
                        <div class="tranding3_side white_bg mb30 padding20 white_bg border-radious5">
                            <h3 class="widget-title">Trending News</h3>
                            <?php
                            foreach ($trendingPosts['data'] as $row){
                                $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                                ?>
                                <div class="single_post post_type3 post_type15 mb10">
                                    <div class="post_img border-radious5">
                                        <div class="img_wrap">
                                            <img src="<?=$row['image_url']?>" alt="<?=$row['post_desc']?>">
                                        </div>
                                        <span class="tranding border_tranding">
									    <i class="fas fa-bolt"></i>
								    </span>
                                    </div>
                                    <div class="single_post_text">
                                        <a href="<?='../../../'.$url?>"><?=$row['post_title']?></a>
                                        <div class="space-10"></div>
                                        <p class="post-p"><?=substr($row['post_content'],0,120)?> ...</p>
                                        <div class="space-20"></div>
                                        <div class="meta3">
                                            <a href="<?='../../../category/'.$row['category']?>"><?=$row['category']?></a>
                                            <a href="#"><?=$postsFunctions->generatePrettyDate($row['post_date'])?></a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                break;
                            }

                            $trendingPostsTrim = $postsFunctions->arrayTrimContent($trendingPosts['data'],4);
                            foreach ($trendingPostsTrim as $row){
                                $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                                ?>
                                <div class="single_post type10 type16 widgets_small mb15">
                                    <div class="post_img">
                                        <a href="<?='../../../'.$url?>">
                                            <img src="<?=$row['image_url']?>" alt="<?=$row['post_desc']?>">
                                        </a>
                                    </div>
                                    <div class="single_post_text">
                                        <h4><a href="<?='../../../'.$url?>"><?=$row['post_title']?></a></h4>
                                        <div class="meta4">	<a href="<?='../../../category/'.$row['category']?>"><?=$row['category']?></a>
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
                        <!--:::::: POST TYPE 3 END :::::::-->
                        <div class="banner2 mb30">
                            <a href="#">
                                <img class="border-radious5" src="assets/img/bg/sidebar-1.png" alt="">
                            </a>
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
                                                <a href="<?='../../../'.$url?>">
                                                    <img src="<?=$row[$i]['image_url']?>" alt="<?=$row[$i]['post_desc']?>">
                                                </a>
                                            </div>
                                            <div class="single_post_text">
                                                <h4><a href="<?='../../../'.$url?>"><?=$row[$i]['post_title']?></a></h4>
                                                <div class="meta4">
                                                    <a href="<?='../../../category/'.$row[$i]['category']?>"><?=$row[$i]['category']?></a>
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
                                                <a href="<?='../../../'.$url?>">
                                                    <img src="<?=$row[$i]['image_url']?>" alt="<?=$row[$i]['post_desc']?>">
                                                </a>
                                            </div>
                                            <div class="single_post_text">
                                                <h4><a href="<?='../../../'.$url?>"><?=$row['post_title']?></a></h4>
                                                <div class="meta4">
                                                    <a href="<?='../../../category/'.$row[$i]['category']?>"><?=$row['category']?></a>
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
        <div class="space-100"></div>
        <!--::::: LATEST BLOG AREA START :::::::-->
        <div class="theme3_bg section-padding layout3">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="heading">
                            <h2 class="widget-title">Our Latest Blog</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <?php
                    $recentPostsOutput30DaysTrim = $postsFunctions->arrayTrimContent($recentPostsOutput30Days['data'],3);
                    foreach ($recentPostsOutput30DaysTrim as $row){
                        $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                        ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="single_post post_type3 mb30 post_type15 border-radious5">
                                <div class="post_img border-radious5">
                                    <div class="img_wrap">
                                        <img src="<?=$row['image_url']?>" alt="<?=$row['post_desc']?>">
                                    </div>
                                    <span class="tranding border_tranding">
								<i class="fas fa-bolt"></i>
							</span>
                                </div>
                                <div class="single_post_text padding20 white_bg">
                                    <a href="<?='../../../'.$url?>"><?=$row['post_title']?></a>
                                    <div class="space-10"></div>
                                    <p class="post-p"><?=substr($row['post_content'],0,120)?></p>
                                    <div class="space-20"></div>
                                    <div class="meta3">
                                        <a href="<?='../../../category/'.$row[$i]['category']?>"><?=$row['category']?></a>
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
        <!--::::: LATEST BLOG AREA END :::::::-->
        <!--	<div class="space-100"></div>-->

        <!--:::::  COMMENT FORM AREA START :::::::-->
        <!--:::::  COMMENT FORM AREA END :::::::-->

        <!--::::: BANNER AREA START :::::::-->
        <div class="section-padding2 theme3_bg layout3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 m-auto">
                        <div class="banner1 border-radious5">
                            <a href="#">
                                <img src="assets/img/bg/banner1.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--::::: BANNER AREA END :::::::-->

        <!--::::: FOOTER AREA START :::::::-->
        <?php include_once 'includes/news_footer_area.php'?>
        <!--::::: FOOTER AREA END :::::::-->

        <!--::::: ALL JS FILES :::::::-->
        <script src="../../../assets/js/plugins/jquery.2.1.0.min.js"></script>
        <script src="../../../assets/js/plugins/bootstrap.min.js"></script>
        <script src="../../../assets/js/plugins/jquery.nav.js"></script>
        <script src="../../../assets/js/plugins/jquery.waypoints.min.js"></script>
        <script src="../../../assets/js/plugins/jquery-modal-video.min.js"></script>
        <script src="../../../assets/js/plugins/owl.carousel.js"></script>
        <script src="../../../assets/js/plugins/popper.min.js"></script>
        <script src="../../../assets/js/plugins/stellarnav.js"></script>
        <script src="../../../assets/js/plugins/circle-progress.js"></script>
        <script src="../../../assets/js/plugins/wow.min.js"></script>
        <script src="../../../assets/js/plugins/slick.min.js"></script>
        <script src="../../../assets/js/main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sharer.js@latest/sharer.min.js"></script>
        <script>
            var today = new Date();
            var months=["January","February","March","April","May","June","July","August","September","October","November","December"];
            var fullDate = months[today.getMonth()]+" "+today.getDate() +", "+today.getFullYear();
            $("#today-date").text(fullDate);
            console.log(fullDate);
        </script>
        </body>

        </html>
        <?php
    }else{
        ?>
        <script>window.location.href = '../../../page-not-found';</script>
        <?php
    }
}else{
    ?>
    <script>window.location.href = '../../../page-not-found';</script>
    <?php
}
?>

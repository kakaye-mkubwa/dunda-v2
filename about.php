<?php
include_once 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>About Us - Dunda Football</title>
	<!-- META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!--::::: FABICON ICON :::::::-->
	<link rel="icon" href="assets/img/icon/fabicon.png">
	<!--::::: ALL CSS FILES :::::::-->
	<link rel="stylesheet" href="assets/css/plugins/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/plugins/animate.min.css">
	<link rel="stylesheet" href="assets/css/plugins/fontawesome.css">
	<link rel="stylesheet" href="assets/css/plugins/modal-video.min.css">
	<link rel="stylesheet" href="assets/css/plugins/owl.carousel.css">
	<link rel="stylesheet" href="assets/css/plugins/slick.css">
	<link rel="stylesheet" href="assets/css/plugins/stellarnav.css">
	<link rel="stylesheet" href="assets/css/theme.css">
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
    <?php include_once 'includes/top_bar.php'?>
	<!--::::: TOP BAR END :::::::-->

	<div class="border_black"></div>

	<!--::::: LOGO AREA START  :::::::-->
    <?php include_once 'includes/logo_area.php'?>
	<!--::::: LOGO AREA END :::::::-->

	<!--::::: MENU AREA START  :::::::-->
    <?php include_once 'includes/menu_area.php'?>
	<!--::::: MENU AREA END :::::::-->

	<!--::::: INNER TABLE AREA START :::::::-->
	<div class="inner_table shadow5 layout3 white_bg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bridcrumb">	<a href="home">Home</a> / About Us</div>
				</div>
			</div>
			<div class="space-50"></div>
			<div class="row">
				<div class="col-12">
					<div class="author_about">

						<div class="author_content">	<a href="home">DundaFootball</a>
							<ul class="inline">
								<li>News Outlet</li>
								<li>Since: April , 2020</li>
							</ul>
						</div>

                        <p>Dunda Football is a football news outlet that keeps you informed on the football latest news, facts, updates, as well as highlights from all over the world. This is a one stop platform for all football related content all for the love of the game</p>
                        <br>
                        <p>Our main objective is to keep you informed and entertained with soccer content tailored just for you. Keep it locked here, for kick off stories, goals, stats, fixtures, results, injuries and everything soccer.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="space-50"></div>
	</div>
	<!--::::: INNER TABLE AREA END :::::::-->

	<!--::::: ARCHIVE AREA START :::::::-->
	<div class="archives padding-top-30">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-8">
					<div class="row">
						<div class="col-10 align-self-center">
							<div class="about_post_list">
								<ul class="nav nav-tabs">
									<li><a class="active" data-toggle="tab" href="#latest">Latest news</a>
									</li>
									<li><a data-toggle="tab" href="#popular">Popular news</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-2 text-right align-self-center">
							<div class="calender mb20">
								<img src="assets/img/icon/calendar.png" alt="">
							</div>
						</div>
					</div>
					<div class="about_posts_tab">
						<div class="tab-content">
							<div id="latest" class="tab-pane fade show in active">
								<div class="row justify-content-center">
                                    <?php
                                    $latestNewsTrim = $postsFunctions->arrayTrimContent($postsOutput['data'],10);
                                    foreach ($latestNewsTrim as $row){
                                        $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                                        ?>
                                        <div class="col-lg-6">
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
                                                    <a href="<?=$url?>"><?=$row['post_title']?></a>
                                                    <div class="space-10"></div>
                                                    <p class="post-p"><?=substr($row['post_content'],0,120)?> ...</p>
                                                    <div class="space-20"></div>
                                                    <div class="meta3">
                                                        <a href="<?='category/'.$row['category']?>"><?=$row['category']?></a>
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
							<div id="popular" class="tab-pane fade">
								<div class="row justify-content-center">
                                    <?php
                                    $recentPostsOutput30DaysTrim = $postsFunctions->shufflePublishedPostsAssoc($recentPostsOutput30Days['data']);
                                    $postsFunctions->arrayTrimContent($recentPostsOutput30DaysTrim,10);
                                    foreach ($recentPostsOutput30DaysTrim as $row){
                                        $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                                        ?>
                                        <div class="col-lg-6">
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
                                                    <a href="news.php"><?=$row['post_title']?></a>
                                                    <div class="space-10"></div>
                                                    <p class="post-p"><?=substr($row['post_content'],0,120)?></p>
                                                    <div class="space-20"></div>
                                                    <div class="meta3">
                                                        <a href="<?='category/'.$row['category']?>"><?=$row['category']?></a>
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
                                    </div>	<span class="tranding border_tranding">
									<i class="fas fa-bolt"></i>
								</span>
                                </div>
                                <div class="single_post_text">	<a href="news.php"><?=$row['post_title']?></a>
                                    <div class="space-10"></div>
                                    <p class="post-p"><?=substr($row['post_content'],0,120)?> ...</p>
                                    <div class="space-20"></div>
                                    <div class="meta3">
                                        <a href="<?='category/'.$row['category']?>"><?=$row['category']?></a>
                                        <a href="#"><?=$postsFunctions->generatePrettyDate($row['post_date'])?></a>
                                    </div>
                                </div>
                            </div>
                            <?php
                            break;
                        }
                        ?>
                        <?php
                        $trendingPostsTrim = $postsFunctions->arrayTrimContent($trendingPosts['data'],4);
                        foreach ($trendingPostsTrim as $row){
                            $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                            ?>
                            <div class="single_post type10 type16 widgets_small mb15">
                                <div class="post_img">
                                    <a href="<?=$url?>">
                                        <img src="<?=$row['image_url']?>" alt="<?=$row['post_desc']?>">
                                    </a>
                                </div>
                                <div class="single_post_text">
                                    <h4><a href="<?=$url?>"><?=$row['post_title']?></a></h4>
                                    <div class="meta4">	<a href="<?='category/'.$row['category']?>"><?=$row['category']?></a>
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
                        <?php
                        foreach ($postsOutput['data'] as $row){
                            $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                            ?>
                            <a href="<?=$url?>">
                                <img class="border-radious5" src="<?=$row['image_url']?>" alt="<?=$row['post_desc']?>">
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
                                $rowsRecent = $postsOutput['data'];
                                for ($i = 0;$i < 5;$i++){
                                    $url = $postsFunctions->newsUrlGenerator($rowsRecent[$i]['post_date'],$rowsRecent[$i]['url_slug']);
                                    ?>
                                    <div class="single_post type10 type16 widgets_small mb15">
                                        <div class="post_img">
                                            <a href="<?=$url?>">
                                                <img src="<?=$rowsRecent[$i]['image_url']?>" alt="<?=$rowsRecent[$i]['post_desc']?>">
                                            </a>
                                        </div>
                                        <div class="single_post_text">
                                            <h4><a href="<?=$url?>"><?=$rowsRecent[$i]['post_title']?></a></h4>
                                            <div class="meta4">
                                                <a href="<?='category/'.$rowsRecent[$i]['category']?>"><?=$rowsRecent[$i]['category']?></a>
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
                                    $url = $postsFunctions->newsUrlGenerator($rowsRecent[$i]['post_date'],$rowsRecent[$i]['url_slug']);
                                    ?>
                                    <div class="single_post type10 type16 widgets_small mb15">
                                        <div class="post_img">
                                            <a href="<?=$url?>">
                                                <img src="<?=$rowsRecent[$i]['image_url']?>" alt="<?=$rowsRecent[$i]['post_desc']?>">
                                            </a>
                                        </div>
                                        <div class="single_post_text">
                                            <h4><a href="<?=$url?>"><?=$rowsRecent[$i]['post_title']?></a></h4>
                                            <div class="meta4">
                                                <a href="<?='category/'.$rowsRecent[$i]['category']?>"><?=$rowsRecent[$i]['category']?></a>
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

	<!--::::: FOOTER AREA START :::::::-->
    <?php include_once 'includes/footer_area.php'?>
	<!--::::: FOOTER AREA END :::::::-->

	<!--::::: ALL JS FILES :::::::-->
    <?php include_once 'includes/scripts.php'?>

</body>

</html>
<?php
include_once 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>NewsPrk 3</title>
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
<!--	::::: PRELOADER START :::::::-->
	<div class="preloader">
		<div>
			<div class="nb-spinner"></div>
		</div>
	</div>
<!--	::::: PRELOADER END :::::::-->

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

	<!--::::: POST GALLARY AREA START :::::::-->
	<div class="post_gallary_area theme3_bg mb40 padding-top-30">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-xl-6">
                    <?php
                    foreach ($postsOutput['data'] as $row){
                        $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                        ?>
                        <div class="single_post post_type6 border-radious7 xs-mb30">
                            <div class="post_img gradient1">
                                <div class="img_wrap">
                                    <a href="<?=$url?>">
                                        <img src="<?=$row['image_url']?>" alt="<?=$row['post_desc']?>">
                                    </a>
                                </div>
                                <span class="tranding">
									<i class="fas fa-play"></i>
								</span>
                            </div>
                            <div class="single_post_text">

                                <h4><a href="<?=$url?>"><?=$row['post_title']?></a></h4>
                                <div class="space-5"></div>

                                <p class="post-p"><?=substr($row['post_content'],0,120)?></p>

                                <div class="space-20"></div>
                                <div class="meta meta_separator1">	<a href="<?='category/'.$row['category']?>"><?=$row['category']?></a>
                                    <a href="#"><?=$postsFunctions->generatePrettyDate($row['post_date']);?></a>
                                </div>
                            </div>
                        </div>
                        <?php
                        break;
                    }
                    ?>
				</div>
				<div class="d-none d-xl-block col-xl-3">
					<div class="white_bg padding15 border-radious5 sm-mt30">
                        <?php
                        $aShuffled = $postsOutput['data'];
                        $aShuffled = $postsFunctions->arrayTrimContent($aShuffled,5);
                        foreach($aShuffled as $row){
                            $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                            ?>
                            <div class="single_post type14 widgets_small">
                                <div class="post_img">
                                    <div class="img_wrap">
                                        <a href="<?=$url?>">
                                            <img src="<?=$row['image_url']?>" alt="<?=$row['post_desc']?>">
                                        </a>
                                    </div>
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
				</div>
				<div class="d-none d-lg-block col-lg-4 col-xl-3">
                    <?php
                    $bShuffled = $postsFunctions->shufflePublishedPostsAssoc($recentPostsOutput30Days['data']);

                    foreach ($bShuffled as $row){
                        $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                        ?>
                        <div class="single_post post_type3 post_type15 mb30 border-radious5 sm-mt30">
                            <div class="post_img">
                                <div class="img_wrap">
                                    <a href="<?=$url?>">
                                        <img src="<?=$row['image_url']?>" alt="<?=$row['post_desc']?>">
                                    </a>
                                </div>	<span class="tranding border_tranding">
									<i class="fas fa-bolt"></i>
								</span>
                            </div>
                            <div class="single_post_text white_bg padding20">
                                <h4><a href="<?=$url?>"><?=$row['post_title']?></a></h4>
                                <div class="space-10"></div>
                                <p class="post-p"><?=substr($row['post_content'],0,120)?> ...</p>
                                <div class="space-20"></div>
                                <div class="meta3">	<a href="<?='category/'.$row['category']?>"><?=$row['category']?></a>
                                    <a href="#"><?=$postsFunctions->generatePrettyDate($row['post_date']);?></a>
                                </div>
                            </div>
                        </div>
                        <?php
                        break;
                    }
                    ?>

				</div>
			</div>
		</div>
	</div>
	<!--::::: POST GALLARY AREA END :::::::-->

	<!--::::: TOTAL AREA START :::::::-->
	<div class="total3 mb30">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-lg-8">
					<div class="white_bg tranding3 padding20 border-radious5 mb30">
						<div class="row">
							<div class="col-12">
								<div class="heading">
									<h2 class="widget-title">Latest News</h2>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
                                <?php
                                $cShuffled = $postsFunctions->shufflePublishedPostsAssoc($recentPostsOutput30Days['data']);

                                foreach ($cShuffled as $row){
                                    $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                                    ?>
                                    <div class="single_post post_type3 xs-mb90 post_type15">
                                        <div class="post_img border-radious5">
                                            <a href="<?=$url?>">
                                                <img src="<?=$row['image_url']?>" alt="<?=$row['post_desc']?>">
                                            </a>
                                            <span class="tranding border_tranding">
											    <i class="fas fa-bolt"></i>
										    </span>
                                        </div>
                                        <div class="single_post_text">
                                            <h4><a href="<?=$url?>"><?=$row['post_title']?></a></h4>
                                            <div class="space-10"></div>
                                            <p class="post-p"><?=substr($row['post_content'],0,120)?> ...</p>
                                            <div class="space-20"></div>
                                            <div class="meta3">	<a href="<?='category/'.$row['category']?>"><?=$row['category']?></a>
                                                <a href="#"><?=$postsFunctions->generatePrettyDate($row['post_date']);?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    break;
                                }
                                ?>
							</div>
							<div class="col-md-6">
								<div class="popular_carousel owl-carousel nav_style1">
									<!--CAROUSEL START-->
									<div class="popular_items mt0">
                                        <?php
                                        $dShuffled = $postsFunctions->shufflePublishedPostsAssoc($postsOutput['data']);
                                        $counter = 1;
                                        foreach ($dShuffled as $row){
                                            $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                                            ?>
                                            <div class="single_post type10 type16 widgets_small mb15">
                                                <div class="post_img">
                                                    <div class="img_wrap">
                                                        <a href="<?=$url?>">
                                                            <img src="<?=$row['image_url']?>" alt="<?=$row['post_desc']?>">
                                                        </a>
                                                    </div>
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
                                            if ($counter == 5){
                                                break;
                                            }else{
                                                $counter++;
                                            }
                                        }
                                        ?>
									</div>
									<div class="popular_items">
										<?php
                                        $eShuffled = $postsFunctions->shufflePublishedPostsAssoc($postsOutput['data']);
                                        $counter = 1;
                                        foreach ($eShuffled as $row){
                                            $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                                            ?>
                                            <div class="single_post type10 type16 widgets_small mb15">
                                                <div class="post_img">
                                                    <div class="img_wrap">
                                                        <a href="<?=$url?>">
                                                            <img src="<?=$row['image_url']?>" alt="<?=$row['post_desc']?>">
                                                        </a>
                                                    </div>
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
                                            if ($counter == 5){
                                                break;
                                            }else{
                                                $counter++;
                                            }
                                        }
                                        ?>
									</div>
								</div>
								<!--CAROUSEL END-->
							</div>
						</div>
					</div>

                    <div class="feature3 mb30">
                        <div class="row">
                            <div class="col-12">
                                <div class="heading padding20 white_bg mb20 border-radious5">
                                    <h3 class="widget-title margin0">Trending News</h3>
                                </div>
                            </div>
                        </div>
                        <div class="feature3_carousel owl-carousel nav_style1">
                            <?php
                            foreach ($trendingPosts['data'] as $row){
                                $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                                ?>
                                <div class="single_post type19 border-radious5 white_bg">
                                    <div class="post_img">
                                        <div class="img_wrap">
                                            <a href="<?=$url?>">
                                                <img src="<?=$row['image_url']?>" alt="<?=$row['post_desc']?>">
                                            </a>
                                        </div>	<span class="batch3 date">
										Trending
									</span>
                                    </div>
                                    <div class="single_post_text padding20">
                                        <p class="post-p"><?=$row['post_title']?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

					<div class="business3 padding20 white_bg border-radious5">
						<h4 class="widget-title">Europe</h4>
                        <?php
                        $europePosts = json_decode($postsFunctions->fetchPostsByCategoryMain("Europe"),true);
                        $europePosts = $postsFunctions->arrayTrimContent($europePosts['data'],6);
                        foreach ($europePosts as $row){
                            $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                            ?>
                            <div class="single_post post_type12 type20 d-lg-none d-xl-block">
                                <div class="post_img border-radious5">
                                    <div class="img_wrap">
                                        <a href="<?=$url?>">
                                            <img src="<?=$row['image_url']?>" alt="<?=$row['post_desc']?>">
                                        </a>
                                    </div>	<span class="tranding border_tranding">
									<i class="fas fa-bolt"></i>
								</span>
                                </div>
                                <div class="single_post_text">
                                    <h4><a href="<?=$url?>"><?=$row['post_title']?></a></h4>
                                    <div class="row">
                                        <div class="col-6 align-self-center">
                                            <div class="meta_col">
                                                <p><?=$postsFunctions->generatePrettyDate($row['post_date'])?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="post-p"><?=substr($row['post_content'],0,159)?> ...</p>
                                    <div class="space-10"></div>
                                    <a href="<?=$url?>" class="readmore3">Read more <img src="assets/img/icon/arrow3.png" alt=""></a>
                                    <div class="space-10"></div>
                                    <div class="border_black"></div>
                                    <div class="space-15"></div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

					</div>
				</div>
				<div class="col-lg-4">
					<div class="row justify-content-center">
						<div class="col-md-6 col-lg-12">
							<div class="most_widget3 padding20 white_bg border-radious5 mb30 sm-mt30">
								<div class="heading">
									<h2 class="widget-title">Featured News</h2>
								</div>
								<div class="post_type2_carousel owl-carousel nav_style1">
									<!--CAROUSEL START-->
									<div class="single_post2_carousel">
                                        <?php
                                        $row = $postsOutput['data'];
                                        for ($i = 0;$i < 5;$i++){
                                            $url = $postsFunctions->newsUrlGenerator($row[$i]['post_date'],$row[$i]['url_slug']);
                                            ?>
                                            <div class="single_post widgets_small type8 type17">
                                                <div class="post_img">
                                                    <div class="img_wrap">
                                                        <a href="<?=$url?>">
                                                            <img src="<?=$row[$i]['image_url']?>" alt="<?=$row[$i]['post_desc']?>">
                                                        </a>
                                                    </div>
                                                    <span class="tranding tranding_border">
														1
                                                    </span>
                                                </div>
                                                <div class="single_post_text">
                                                    <h4><a href="<?=$url?>"><?=$row[$i]['post_title']?></a></h4>
                                                    <div class="meta2">	<a href="<?='category/'.$row[$i]['category']?>"><?=$row[$i]['category']?></a>
                                                        <a href="#"><?=$postsFunctions->generatePrettyDate($row[$i]['post_date'])?></a>
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
									<div class="single_post2_carousel">
                                        <?php
                                        $row = $postsOutput['data'];
                                        for ($i = 5;$i < 10;$i++){
                                            $url = $postsFunctions->newsUrlGenerator($row[$i]['post_date'],$row[$i]['url_slug']);
                                            ?>
                                            <div class="single_post widgets_small type8 type17">
                                                <div class="post_img">
                                                    <div class="img_wrap">
                                                        <a href="<?=$url?>">
                                                            <img src="<?=$row[$i]['image_url']?>" alt="<?$row[$i]['post_desc']?>">
                                                        </a>
                                                    </div>	<span class="tranding tranding_border">
															1
														</span>
                                                </div>
                                                <div class="single_post_text">
                                                    <h4><a href="<?=$url?>"><?=$row[$i]['post_title']?></a></h4>
                                                    <div class="meta2">	<a href="<?='category/'.$row[$i]['category']?>"><?=$row[$i]['category']?></a>
                                                        <a href="#"><?=$postsFunctions->generatePrettyDate($row[$i]['post_date'])?></a>
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
						<div class="col-md-6 col-lg-12 d-md-none d-lg-block">
                            <?php
                            foreach ($postsOutput['data'] as $row){
                                $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                                ?>
                                <div class="banner2 mb30 border-radious5">
                                    <a href="<?=$url?>">
                                        <img src="<?=$row['image_url']?>" alt="<?=$row['post_desc']?>">
                                    </a>
                                </div>
                                <?php
                                break;
                            }
                            ?>
						</div>
						<div class="col-md-6 col-lg-12">
							<div class="finance mb30 white_bg border-radious5 padding20 sm-mt30">
								<div class="heading">
									<h3 class="widget-title">International</h3>
								</div>
                                <?php
                                $internationalPosts = json_decode($postsFunctions->fetchPostsByCategoryMain("International"),true);
                                $internationalPosts = $postsFunctions->arrayTrimContent($internationalPosts['data'],3);
                                foreach ($internationalPosts as $row){
                                    $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                                    ?>
                                    <div class="single_post mb30 type18 d-md-none d-lg-block">
                                        <div class="post_img">
                                            <div class="img_wrap">
                                                <a href="<?=$url?>">
                                                    <img src="<?=$row['image_url']?>" alt="<?=$row['post_desc']?>">
                                                </a>
                                            </div>	<span class="batch3 date"><?=$postsFunctions->generatePrettyDate($row['post_date'])?></span>
                                        </div>
                                        <div class="single_post_text">
                                            <h4><a href="<?=$url?>"><?=$row['post_title']?></a></h4>
                                            <div class="space-10"></div>
                                            <p class="post-p"><?=substr($row['post_content'],0,120)?> ...</p>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>

									<a href="<?='category/International'?>" class="showmore">Show more</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--::::: TOTAL AREA END :::::::-->

	<div class="space-100"></div>

    <!--::::: FOOTER AREA START :::::::-->
    <?php include_once 'includes/footer_area.php'?>
    <!--::::: FOOTER AREA END :::::::-->

    <!--::::: ALL JS FILES :::::::-->
    <?php include_once 'includes/scripts.php'?>
</body>

</html>
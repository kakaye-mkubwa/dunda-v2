<div class="footer footer_area3 white_bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="single_footer3 mb30">
                    <div class="logo">
                        <a href="../home">
                            <img src="../assets/img/logo/logo.png" alt="logo">
                        </a>
                        <div class="space-20"></div>
                        <p><span>Dunda Football</span> , sharing facts and news about the game. All for the love of the game</p>
                    </div>
                </div>
                <div class="footer_contact">
                    <h3 class="widget-title2">Dunda Football news services</h3>
                    <div class="single_fcontact">
                        <div class="fcicon">
                            <img src="../assets/img/icon/phone_black.png" alt="">
                        </div>	<a href="#">On your mobile</a>
                    </div>
                    <div class="single_fcontact">
                        <div class="fcicon">
                            <img src="../assets/img/icon/envelope_black.png" alt="">
                        </div>	<a href="#">Contact Newspark news</a>
                    </div>
                </div>
                <div class="space-30"></div>
                <div class="border_black"></div>
                <div class="space-30"></div>
                <div class="single_footer_nav mb30">
                    <h3 class="widget-title2">Popular Tags</h3>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul>
                                <?php
                                foreach ($popularTags['data'] as $row){
                                    ?>
                                    <li><a href="<?='../tag/'.$row['tag_name']?>"><?=$row['tag_name']?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="space-30"></div>
                <div class="border_black"></div>
                <div class="space-30"></div>
            </div>
            <div class="col-lg-8 col-md-6">
                <div class="contacts3">

                    <div class="single_contact3">
                        <h6>Let's Chat</h6>
                        <a href="mailto:support@dundafootball.com">support@dundafootball.com</a>
                        <!--                        <a href="mailto:adsales@newspark.com">adsales@newspark.com</a>-->
                    </div>
                </div>
                <div class="space-30"></div>
                <div class="border_black"></div>
                <div class="space-30"></div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="footer_more_news mb30">
                            <h3 class="widget-title">More news</h3>
                            <div class="more_newss">
                                <?php
                                $footerNews = $postsFunctions->arrayTrimContent($recentPostsOutput30Days['data'],4);
                                foreach ($footerNews as $row){
                                    $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                                    ?>
                                    <div class="single_more_news">
                                        <p class="meta"><?=$row['category']?></p>
                                        <h4><a href="<?='../'.$url?>"><?=$row['post_title']?></a></h4>
                                        <p><?=substr($row['post_content'],0,92)?> ...</p>
                                        <ul class="mt20 like_cm">
                                            <li><a href="#"><i class="far fa-eye"></i> <?=rand(600,1000);?> </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="space-15"></div>
                                    <div class="border_black"></div>
                                    <div class="space-15"></div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="follow_box widget mb30">
                            <h2 class="widget-title">Follow Us</h2>
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
                        <?php
                        $recentPostsOutput30DaysTrim = $postsFunctions->arrayTrimContent($recentPostsOutput30Days['data'],2);
                        foreach ($recentPostsOutput30DaysTrim as $row){
                            $url = $postsFunctions->newsUrlGenerator($row['post_date'],$row['url_slug']);
                            ?>
                            <div class="banner2 mb30 ">
                                <a href="<?='../'.$url?>" class="border-radious5">
                                    <img src="<?=$row['image_url']?>" alt="<?=$row['post_desc']?>">
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <p>&copy; Copyright DundaFootball 2020, All Rights Reserved</p>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="copyright_menus text-right">
                        <div class="language"></div>
                        <div class="copyright_menu inline">
                            <ul>
                                <li><a href="../about">About</a>
                                </li>
                                <li><a href="../privacy_policy">Privacy & Policy</a>
                                </li>
                                <li><a href="../contact">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
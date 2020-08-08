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
                                    <a href="<?=$url?>"><?=$row['post_title']?></a>
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
                            <li><a href="#"><i class="fab fa-instagram"></i></a>
                            </li>
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a>
                            </li>
                            <li><a href="#"><i class="fab fa-instagram"></i></a>
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
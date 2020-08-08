<div class="container">
    <div class="main-menu">
        <div class="main-nav clearfix is-ts-sticky">
            <div class="row justify-content-between">
                <div class="col-4 col-lg-9 align-self-center">
                    <div class="newsprk_nav stellarnav">
                        <ul id="newsprk_menu">
                            <li><a href="home">Home </a></li>
                            <li><a href="#">Categories <i class="fal fa-angle-down"></i></a>
                                <ul>
                                    <?php
                                    foreach ($outputCategories['data'] as $row){
                                        ?>
                                        <li class="active">
                                            <a href="<?='category/'.$row['category_name']?>"><?=$row['category_name']?></a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>

                            </li>
                            <li><a href="about">About</a></li>
                            <li><a href="contact">Contact</a></li>
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

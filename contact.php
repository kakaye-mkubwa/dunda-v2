<?php
include_once 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Contact Us</title>
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

<body class="theme-3">
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

	<!--::::: INNER AREA START :::::::-->
	<div class="inner inner_bg inner_overlay">
		<div class="container">
			<div class="inner_wrap">
				<div class="row">
					<div class="col-lg-6">
						<div class="title_inner">
							<h6>CONTACT US</h6>
							<h1>let's Contact</h1>
						</div>
					</div>
				</div>
				<div class="inner_scroll">
					<a href="#inner">
						<img src="assets/img/icon/scroll.png" alt="">
					</a>
				</div>
			</div>
		</div>
	</div>
	<!--::::: INNER AREA END :::::::-->

	<!--::::: BCAKGROUND AREA START :::::::-->
	<div class="fifth_bg">
		<!--::::: CONTACT FORM AREA START :::::::-->
		<div class="contact_form padding-bottom">
			<div class="container">
				<div class="space-50"></div>
				<div class="row">
					<div class="col-md-8">
						<div class="cotact_form">
							<div class="row">
								<div class="col-12">
									<h3>Get in touch with us! <br> Fill out the form.</h3>
								</div>
								<div class="col-12">
									<form action="home">
										<div class="row">
											<div class="col-lg-6">
												<input type="text" placeholder="Full Name">
											</div>
											<div class="col-lg-6">
												<input type="text" placeholder="Subject">
											</div>
											<div class="col-lg-6">
												<input type="email" placeholder="Email Adress">
											</div>
											<div class="col-12">
												<textarea name="messege" id="messege" cols="30" rows="5" placeholder="Tell us about your message…"></textarea>
											</div>
											<div class="col-12">
												<div class="space-20"></div>
												<input class="cbtn1" type="button" value="Send Message">
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="follow_box widget mb30">
							<h2 class="widget-title">Follow Us</h2>
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
					</div>
				</div>
			</div>
		</div>
		<!--::::: CONTACT FORM AREA END :::::::-->
	</div>
	<!--::::: BCAKGROUND AREA END :::::::-->

	<!--::::: FOOTER AREA START :::::::-->
    <?php include_once 'includes/footer_area.php'?>
	<!--::::: FOOTER AREA END :::::::-->

	<!--::::: ALL JS FILES :::::::-->
    <?php include_once 'includes/scripts.php'?>
</body>

</html>
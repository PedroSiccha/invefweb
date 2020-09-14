<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Basic Page Needs
	================================================== -->
	<meta charset="utf-8">
    <title>INVEF | NOSOTROS </title>
    <meta name="description" content="">	
	<meta name="author" content="">

	<!-- Mobile Specific Metas
	================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Favicons
	================================================== -->
	<link rel="icon" href="{{asset('web/images/invefLogoMini.png')}}" type="image/x-icon" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('web/images/invefLogoMini.png')}}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('web/images/invefLogoMini.png')}}">
	<link rel="apple-touch-icon-precomposed" href="{{asset('web/images/invefLogoMini.png')}}">
	
	<!-- CSS
	================================================== -->
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="{{asset('web/css/bootstrap.min.css')}}">
	<!-- Template styles-->
	<link rel="stylesheet" href="{{asset('web/css/style.css')}}">
	<!-- Responsive styles-->
	<link rel="stylesheet" href="{{asset('web/css/responsive.css')}}">
	<!-- FontAwesome -->
	<link rel="stylesheet" href="{{asset('web/css/font-awesome.min.css')}}">
	<!-- Animation -->
	<link rel="stylesheet" href="{{asset('web/css/animate.css')}}">
	<!-- Prettyphoto -->
	<link rel="stylesheet" href="{{asset('web/css/prettyPhoto.css')}}">
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="{{asset('web/css/owl.carousel.css')}}">
	<link rel="stylesheet" href="{{asset('web/css/owl.theme.css')}}">
	<!-- Flexslider -->
	<link rel="stylesheet" href="{{asset('web/css/flexslider.css')}}">
	<!-- Flexslider -->
	<link rel="stylesheet" href="{{asset('web/css/cd-hero.css')}}">
	<!-- Style Swicther -->
	<link id="style-switch" href="{{asset('web/css/presets/preset1.css')}}" media="screen" rel="stylesheet" type="text/css">

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

</head>
	
<body>

	<div class="body-inner">
	<!-- Header start -->
	<header id="header" class="navbar-fixed-top header2" role="banner">
		<div class="container">
			<div class="row">
				<!-- Logo start -->
				<div class="navbar-header">
				    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				        <span class="sr-only">Barra de Navegación</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				    </button>
				    <div class="navbar-brand">
					    <a href="{{ Route('web') }}">
					    	<img class="img-responsive" src="{{asset('web/images/logoExtendido.png')}}" alt="logo">
					    </a> 
				    </div>                   
				</div><!--/ Logo end -->
				<nav class="collapse navbar-collapse clearfix" role="navigation">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown active">
                       		<a href="{{ Route('web') }}" class="dropdown-toggle" data-toggle="dropdown">Inicio <i class="fa fa-angle-down"></i></a>
	                    </li>
						<li class="dropdown">
                       		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Nosotros <i class="fa fa-angle-down"></i></a>
                       		<div class="dropdown-menu">
								<ul>
		                            <li><a href="about.html">Sobre Nosotros</a></li>
		                            <li><a href="service.html">Servicios</a></li>
		                            <li><a href="faq.html">Preguntas Frecuentes</a></li>
		                        </ul>
	                    	</div>
	                    </li>
						<li class="dropdown">
                       		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Liquidaciones <i class="fa fa-angle-down"></i></a>
                       		<div class="dropdown-menu">
								<ul>
		                            <li><a href="portfolio-classic.html">Equipos</a></li>
		                        </ul>
	                    	</div>
	                    </li>
						<li><a href="{{ Route('login') }}">Ingresar</a></li>
						<li><a href="{{ Route('cli') }}">Registrar</a></li>
                    </ul>
				</nav><!--/ Navigation end -->
			</div><!--/ Row end -->
		</div><!--/ Container end -->
	</header><!--/ Header end -->

	<!-- Slider start -->
	<div id="banner-area">
		<img src="{{ asset('web/images/banner/banner1.jpg') }}" alt ="" />
		<div class="parallax-overlay"></div>
			<!-- Subpage title start -->
			<div class="banner-title-content">
	        	<div class="text-center">
		        	<h2>Nosotros</h2>
	          	</div>
          	</div><!-- Subpage title end -->
	</div>

    <!-- About tab start -->
	<section id="main-container">
		<div class="container">

			<!-- Company Profile -->

			<div class="row">
				<div class="col-md-12 heading text-center">
					<h2 class="title2">Sobre Nosotros
						<span class="title-desc">En esta sección le contamos un poco más sobre nuestra empresa</span>
					</h2>
				</div>
			</div><!-- Title row end -->

			<div class="row about-wrapper-top">
				<div class="col-md-6 ts-padding about-message">
					<h3>Finalidad</h3>
					<p>"Cras mattis consectetur purus sit amet fermentum. Etiam porta sem malesuada magna mollis euismod. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed posuere consectetur est at lobortis. Donec ullamcorper nulla non metus auctor fringilla. Lorem ipsum dolor sit amet mattis ut consequat mauris cursus.</p>
					<p>Curabitur metus felis, venenatis eu ultricies vel, vehicula eu urna. Phasellus eget augue id est fringilla feugiat id a tellus. Sed hendrerit quam sed ante euismod posuere element ante."</p>
				</div><!--/ About message end -->
				<div class="col-md-6 ts-padding about-img" style="height:374px;background:url(web/images/pages/about-1.jpg) 50% 50% / cover no-repeat;">
				</div><!--/ About image end -->
			</div><!--/ Content row end -->

			<div class="row about-wrapper-bottom">
				<div class="col-md-6 ts-padding about-img" style="height:374px;background:url(web/images/pages/about-2.jpg) 50% 50% / cover no-repeat;">
				</div><!--/ About image end -->
				<div class="col-md-6 ts-padding about-message">
					<h3>Objetivos</h3>
					<p>"Cras mattis consectetur purus sit amet fermentum. Etiam porta sem malesuada magna mollis euismod. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed posuere consectetur est at lobortis.</p>
					<ul class="unstyled arrow">
						<li><a href="#">Etiam porta sem malesuada</a></li>
						<li><a href="#">Pellentesque ornare sem lacinia</a></li>
						<li><a href="#">Cras mattis consectetur purus</a></li>
						<li><a href="#">Sed hendrerit quam sed ante</a></li>
					</ul>
				</div><!--/ About message end -->
			</div><!--/ Content row end -->

			<!-- Company Profile -->

		</div><!--/ 1st container end -->

			
		<div class="gap-60"></div>


		<!-- Counter Strat -->
		<div class="ts_counter_bg parallax parallax2">
			<div class="parallax-overlay"></div>
			<div class="container">
				<div class="row wow fadeInLeft text-center">
					<div class="facts col-md-3 col-sm-6">
						<span class="facts-icon"><i class="fa fa-user"></i></span>
						<div class="facts-num">
							<span class="counter">1200</span>
						</div>
						<h3>Clients</h3> 
					</div>

					<div class="facts col-md-3 col-sm-6">
						<span class="facts-icon"><i class="fa fa-institution"></i></span>
						<div class="facts-num">
							<span class="counter">1277</span>
						</div>
						<h3>Item Sold</h3> 
					</div>

					<div class="facts col-md-3 col-sm-6">
						<span class="facts-icon"><i class="fa fa-suitcase"></i></span>
						<div class="facts-num">
							<span class="counter">869</span>
						</div>
						<h3>Projects</h3> 
					</div>

					<div class="facts col-md-3 col-sm-6">
						<span class="facts-icon"><i class="fa fa-trophy"></i></span>
						<div class="facts-num">
							<span class="counter">76</span>
						</div>
						<h3>Awwards</h3> 
					</div>

					<div class="gap-40"></div>

					<div><a href="#" class="btn btn-primary solid">See Our Portfolio</a></div>

				</div><!--/ row end -->
			</div><!--/ Container end -->
		</div><!--/ Counter end -->

		<div class="gap-60"></div>


		<div class="container"><!-- 2nd container start -->

			<!-- Team start -->
			<div class="team">

				<div class="row">
					<div class="col-md-12 heading text-center">
						<h2 class="title2">Meet With Our Company
							<span class="title-desc">A Quality Experience Team with 4 years experience</span>
						</h2>
					</div>
				</div><!-- Title row end -->

				<div class="row text-center">
					<div class="col-md-3 col-sm-6">
						<div class="team wow slideInLeft">
							<div class="img-hexagon">
								<img src="{{ asset('web/images/team/team1.jpg') }}" alt="">
								<span class="img-top"></span>
								<span class="img-bottom"></span>
							</div>
							<div class="team-content">
								<h3>Vosgi Varduhi</h3>
								<p>Web Designer</p>
								<div class="team-social">
									<a class="fb" href="#"><i class="fa fa-facebook"></i></a>
									<a class="twt" href="#"><i class="fa fa-twitter"></i></a>
									<a class="gplus" href="#"><i class="fa fa-google-plus"></i></a>
									<a class="linkdin" href="#"><i class="fa fa-linkedin"></i></a>
									<a class="dribble" href="#"><i class="fa fa-dribbble"></i></a>
								</div>
							</div>
						</div>	
					</div><!--/ Team 1 end -->
					<div class="col-md-3 col-sm-6">
						<div class="team wow slideInLeft">
							<div class="img-hexagon">
								<img src="{{ asset('web/images/team/team2.jpg') }}" alt="">
								<span class="img-top"></span>
								<span class="img-bottom"></span>
							</div>
							<div class="team-content">
								<h3>Robert Aleska</h3>
								<p>Web Designer</p>
								<div class="team-social">
									<a class="fb" href="#"><i class="fa fa-facebook"></i></a>
									<a class="twt" href="#"><i class="fa fa-twitter"></i></a>
									<a class="gplus" href="#"><i class="fa fa-google-plus"></i></a>
									<a class="linkdin" href="#"><i class="fa fa-linkedin"></i></a>
									<a class="dribble" href="#"><i class="fa fa-dribbble"></i></a>
								</div>
							</div>
						</div>
					</div><!--/ Team 2 end -->
					<div class="col-md-3 col-sm-6">
						<div class="team wow slideInRight">
							<div class="img-hexagon">
								<img src="{{ asset('web/images/team/team3.jpg') }}" alt="">
								<span class="img-top"></span>
								<span class="img-bottom"></span>
							</div>
							<div class="team-content">
								<h3>Taline Voski</h3>
								<p>Web Designer</p>
								<div class="team-social">
									<a class="fb" href="#"><i class="fa fa-facebook"></i></a>
									<a class="twt" href="#"><i class="fa fa-twitter"></i></a>
									<a class="gplus" href="#"><i class="fa fa-google-plus"></i></a>
									<a class="linkdin" href="#"><i class="fa fa-linkedin"></i></a>
									<a class="dribble" href="#"><i class="fa fa-dribbble"></i></a>
								</div>
							</div>
						</div>
					</div><!--/ Team 3 end -->
					<div class="col-md-3 col-sm-6">
						<div class="team animate wow slideInRight">
							<div class="img-hexagon">
								<img src="{{ asset('web/images/team/team4.jpg') }}" alt="">
								<span class="img-top"></span>
								<span class="img-bottom"></span>
							</div>
							<div class="team-content">
								<h3>Alban Spencer</h3>
								<p>Web Designer</p>
								<div class="team-social">
									<a class="fb" href="#"><i class="fa fa-facebook"></i></a>
									<a class="twt" href="#"><i class="fa fa-twitter"></i></a>
									<a class="gplus" href="#"><i class="fa fa-google-plus"></i></a>
									<a class="linkdin" href="#"><i class="fa fa-linkedin"></i></a>
									<a class="dribble" href="#"><i class="fa fa-dribbble"></i></a>
								</div>
							</div>
						</div>
					</div><!--/ Team 4 end -->
				</div><!--/ Content row end -->

			</div><!-- Team end -->

		</div><!-- 2nd container end -->
	</section>	

	<!-- Footer start -->
	<footer id="footer" class="footer footer2">
		<div class="container">

			<div class="row">
				<!--
				<div class="col-md-4 col-sm-12 footer-widget">
					<h3 class="widget-title">Flickr Photos</h3>

					<div class="img-gallery">
						<div class="img-container">
							<a class="thumb-holder" data-rel="prettyPhoto" href="{{ asset('web/images/gallery/1.jpg') }}">
								<img src="{{ asset('web/images/gallery/1.jpg') }}" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="{{ asset('web/images/gallery/2.jpg') }}">
								<img src="{{ asset('web/images/gallery/2.jpg') }}" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="{{ asset('web/images/gallery/3.jpg') }}">
								<img src="{{ asset('web/images/gallery/3.jpg') }}" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="{{ asset('web/images/gallery/4.jpg') }}">
								<img src="{{ asset('web/images/gallery/4.jpg') }}" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="{{ asset('web/images/gallery/5.jpg') }}">
								<img src="{{ asset('web/images/gallery/5.jpg') }}" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="{{ asset('web/images/gallery/6.jpg') }}">
								<img src="{{ asset('web/images/gallery/6.jpg') }}" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="{{ asset('web/images/gallery/7.jpg') }}">
								<img src="{{ asset('web/images/gallery/7.jpg') }}" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="{{ asset('web/images/gallery/8.jpg') }}">
								<img src="{{ asset('web/images/gallery/8.jpg') }}" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="{{ asset('web/images/gallery/9.jpg') }}">
								<img src="{{ asset('web/images/gallery/9.jpg') }}" alt="">
							</a>
						</div>
					</div>

						
				</div> -->

				<div class="col-md-4 col-sm-12 footer-widget">
					<h3 class="widget-title">Disponibles</h3>

					<ul class="unstyled arrow">
						<li><a href="#">Acerca de Nosotros</a></li>
						<li><a href="#">Como Ayudamos</a></li>
						<li><a href="#">Próximos Eventos</a></li>
						<li><a href="#">Atención al Cliente</a></li>
						<li><a href="#">Registrate</a></li>
						<li><a href="#">Ultimas Noticias</a></li>
						<li><a href="#">Servicios</a></li>
						<li><a href="#">Liquidaciones</a></li>
						<li><a href="#">Próximamente</a></li>
						<li><a href="#">Contáctenos</a></li>
					</ul>
	
				</div><!--/ End Recent Posts-->


				<div class="col-md-3 col-sm-12 footer-widget footer-about-us">
					<h3 class="widget-title">Sobre Nosotroas</h3>
					<p>Somos una empresa de prestamos por garantías.</p>
					<p><strong>Dirección: </strong>Jr. Sebastian de Aliste 209 - Independencia - Huaraz</p>
					<div class="row">
						<div class="col-md-6">
							<strong>Correo: </strong>
							<p>invef123@gmail.com</p>
						</div>
						<div class="col-md-6">
							<strong>Teléfono.</strong>
							<p>+(51) 939214860</p>
						</div>
					</div>
					<br/>
				</div><!--/ end about us -->




			</div><!-- Row end -->
		</div><!-- Container end -->
	</footer><!-- Footer end -->
	

	<!-- Footer start -->
	<section id="copyright" class="copyright angle">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<ul class="footer-social unstyled">
						<li>
							<a title="Facebook" href="#">
								<span class="icon-pentagon wow bounceIn"><i class="fa fa-facebook"></i></span>
							</a>
							<a title="Google+" href="#">
								<span class="icon-pentagon wow bounceIn"><i class="fa fa-google-plus"></i></span>
							</a>
							<a title="Dribble" href="#">
								<span class="icon-pentagon wow bounceIn"><i class="fa fa-whatsapp"></i></span>
							</a>
						</li>
					</ul>
				</div>
			</div><!--/ Row end -->
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="copyright-info">
         			 <span> <a href="https://inforad.net.pe">inforad.net.pe</a></span>
        			</div>
				</div>
			</div><!--/ Row end -->
		   <div id="back-to-top" data-spy="affix" data-offset-top="10" class="back-to-top affix">
				<button class="btn btn-primary" title="Back to Top"><i class="fa fa-angle-double-up"></i></button>
			</div>
		</div><!--/ Container end -->
	</section><!--/ Footer end -->

	<!-- Javascript Files
	================================================== -->

	<!-- initialize jQuery Library -->
	<script type="text/javascript" src="{{asset('web/js/jquery.js')}}"></script>
	<!-- Bootstrap jQuery -->
	<script type="text/javascript" src="{{asset('web/js/bootstrap.min.js')}}"></script>
	<!-- Style Switcher -->
	<script type="text/javascript" src="{{asset('web/js/style-switcher.js')}}"></script>
	<!-- Owl Carousel -->
	<script type="text/javascript" src="{{asset('web/js/owl.carousel.js')}}"></script>
	<!-- PrettyPhoto -->
	<script type="text/javascript" src="{{asset('web/js/jquery.prettyPhoto.js')}}"></script>
	<!-- Bxslider -->
	<script type="text/javascript" src="{{asset('web/js/jquery.flexslider.js')}}"></script>
	<!-- Owl Carousel -->
	<script type="text/javascript" src="{{asset('web/js/cd-hero.js')}}"></script>
	<!-- Isotope -->
	<script type="text/javascript" src="{{asset('web/js/isotope.js')}}"></script>
	<script type="text/javascript" src="{{asset('web/js/ini.isotope.js')}}"></script>
	<!-- Wow Animation -->
	<script type="text/javascript" src="{{asset('web/js/wow.min.js')}}"></script>
	<!-- SmoothScroll -->
	<script type="text/javascript" src="{{asset('web/js/smoothscroll.js')}}"></script>
	<!-- Eeasing -->
	<script type="text/javascript" src="{{asset('web/js/jquery.easing.1.3.js')}}"></script>
	<!-- Counter -->
	<script type="text/javascript" src="{{asset('web/js/jquery.counterup.min.js')}}"></script>
	<!-- Waypoints -->
	<script type="text/javascript" src="{{asset('web/js/waypoints.min.js')}}"></script>
	<!-- Template custom -->
	<script type="text/javascript" src="{{asset('web/js/custom.js')}}"></script>
	</div><!-- Body inner end -->
</body>
</html>
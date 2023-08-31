<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Basic Page Needs
	================================================== -->
	<meta charset="utf-8">
    <title>INVEF | PRODUCTOS</title>
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

	<link href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="{{ asset('web/js/html5shiv.js') }}"></script>
      <script src="{{ asset('web/js/respond.min.js') }}"></script>
    <![endif]-->

</head>
	
<body>
	<div class="body-inner">
	<!-- Header start -->
	<header id="header" class="navbar-fixed-top header" role="banner">
		<div class="container">
			<div class="row">
				<!-- Logo start -->
				<div class="navbar-header">
				    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				    </button>
				    <div class="navbar-brand navbar-bg">
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
                                 <li><a href="{{ Route('nosotros') }}">Sobre Nosotros</a></li>
                                 <li><a href="{{ Route('servicios') }}">Servicios</a></li>
                                 <li><a href="{{ Route('preguntas') }}">Preguntas Frecuentes</a></li>
                             </ul>
                         </div>
                     </li>
						<li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Liquidaciones <i class="fa fa-angle-down"></i></a>
                       		<div class="dropdown-menu">
								<ul>
		                            <li><a href="{{ Route('equipos') }}">Equipos</a></li>
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

	<div id="banner-area">
		<img src="{{ ('web/images/banner/banner2.jpg') }}" alt ="" />
		<div class="parallax-overlay"></div>
			<!-- Subpage title start -->
	</div><!-- Banner area end -->

	
	<!-- Portfolio start -->
	<section id="main-container" class="portfolio portfolio-box">
		<div class="container">
			<!--Isotope filter start -->
			<div class="row text-center">
				<div class="isotope-nav" data-isotope-nav="isotope">
					<ul>
						<li><a href="#" class="active" data-filter="*">Todos</a></li>
						<li><a href="#" data-filter=".web-design">Computo</a></li>
						<li><a href="#" data-filter=".development">Celulares</a></li>
						<li><a href="#" data-filter=".joomla">Televisores</a></li>
						<li><a href="#" data-filter=".wordpress">Joyas</a></li>
					</ul>
				</div>
			</div><!-- Isotope filter end -->
			
			<div class="row">
				<div id="isotope" class="isotope">
					<div class="col-sm-3 web-design isotope-item">
						<div class="grid">
							<figure class="effect-oscar">
								<img src="{{ asset('web/images/portfolio/portfolio1.jpg') }}" alt="">
								<figcaption>
									<h3>Startup Business</h3>
									<a class="link icon-pentagon" href="{{ Route('detalleProducto') }}"><i class="fa fa-link"></i></a>
									<a class="view icon-pentagon" data-rel="prettyPhoto" href="{{ asset('web/images/portfolio/portfolio-bg1.jpg') }}"><i class="fa fa-search"></i></a>            
								</figcaption>			
							</figure>
						</div>
					</div><!-- Isotope item end -->

					<div class="col-sm-3 development isotope-item">
						<div class="grid">
							<figure class="effect-oscar">
								<img src="{{ asset('web/images/portfolio/portfolio2.jpg') }}" alt="">
								<figcaption>
									<h3>Easy to Lanunch</h3>
									<a class="link icon-pentagon" href="portfolio-item.html"><i class="fa fa-link"></i></a>
									<a class="view icon-pentagon" data-rel="prettyPhoto" href="{{ asset('web/images/portfolio/portfolio-bg2.jpg') }}"><i class="fa fa-search"></i></a>            
								</figcaption>				
							</figure>
						</div>
					</div><!-- Isotope item end -->

					<div class="col-sm-3 joomla isotope-item">
						<div class="grid">
							<figure class="effect-oscar">
								<img src="{{ asset('web/images/portfolio/portfolio3.jpg') }}" alt="">
								<figcaption>
									<h3>Your Business</h3>
									<a class="link icon-pentagon" href="portfolio-item.html"><i class="fa fa-link"></i></a>
									<a class="view icon-pentagon" data-rel="prettyPhoto" href="{{ asset('web/images/portfolio/portfolio-bg3.jpg') }}"><i class="fa fa-search"></i></a>            
								</figcaption>				
							</figure>
						</div>
					</div><!-- Isotope item end -->

					<div class="col-sm-3 wordpress isotope-item">
						<div class="grid">
							<figure class="effect-oscar">
								<img src="{{ asset('web/images/portfolio/portfolio4.jpg') }}" alt="">
								<figcaption>
									<h3>Prego Match</h3>
									<a class="link icon-pentagon" href="portfolio-item.html"><i class="fa fa-link"></i></a>
									<a class="view icon-pentagon" data-rel="prettyPhoto" href="{{ asset('web/images/portfolio/portfolio-bg4.jpg') }}"><i class="fa fa-search"></i></a>            
								</figcaption>					
							</figure>
						</div>
					</div><!-- Isotope item end -->

					<div class="col-sm-3 joomla isotope-item">
						<div class="grid">
							<figure class="effect-oscar">
								<img src="{{ asset('web/images/portfolio/portfolio5.jpg') }}" alt="">
								<figcaption>
									<h3>Fashion Brand</h3>
									<a class="link icon-pentagon" href="portfolio-item.html"><i class="fa fa-link"></i></a>
									<a class="view icon-pentagon" data-rel="prettyPhoto" href="{{ asset('web/images/portfolio/portfolio-bg5.jpg') }}"><i class="fa fa-search"></i></a>            
								</figcaption>					
							</figure>
						</div>
					</div><!-- Isotope item end -->

					<div class="col-sm-3 development isotope-item">
						<div class="grid">
							<figure class="effect-oscar">
								<img src="{{ asset('web/images/portfolio/portfolio6.jpg') }}" alt="">
								<figcaption>
									<h3>The Insidage</h3>
									<a class="link icon-pentagon" href="portfolio-item.html"><i class="fa fa-link"></i></a>
									<a class="view icon-pentagon" data-rel="prettyPhoto" href="{{ asset('web/images/portfolio/portfolio-bg1.jpg') }}"><i class="fa fa-search"></i></a>            
								</figcaption>					
							</figure>
						</div>
					</div><!-- Isotope item end -->

					<div class="col-sm-3 development isotope-item">
						<div class="grid">
							<figure class="effect-oscar">
								<img src="{{ asset('web/images/portfolio/portfolio7.jpg') }}" alt="">
								<figcaption>
									<h3>Light Carpet</h3>
									<a class="link icon-pentagon" href="portfolio-item.html"><i class="fa fa-link"></i></a>
									<a class="view icon-pentagon" data-rel="prettyPhoto" href="{{ asset('web/images/portfolio/portfolio-bg2.jpg') }}"><i class="fa fa-search"></i></a>            
								</figcaption>					
							</figure>
						</div>
					</div><!-- Isotope item end -->

					<div class="col-sm-3 development isotope-item">
						<div class="grid">
							<figure class="effect-oscar">
								<img src="{{ asset('web/images/portfolio/portfolio8.jpg') }}" alt="">
								<figcaption>
									<h3>Amazing Keyboard</h3>
									<a class="link icon-pentagon" href="portfolio-item.html"><i class="fa fa-link"></i></a>
									<a class="view icon-pentagon" data-rel="prettyPhoto" href="{{ asset('web/images/portfolio/portfolio-bg3.jpg') }}"><i class="fa fa-search"></i></a>            
								</figcaption>					
							</figure>
						</div>
					</div><!-- Isotope item end -->
				</div><!-- Isotope content end -->
			</div><!-- Content row end -->
		</div><!-- Container end -->
	</section><!-- Portfolio end -->

	<div class="gap-40"></div>

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
<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Basic Page Needs
	================================================== -->
	<meta charset="utf-8">
    <title>INVEF | PREGUNTAS FRECUENTES</title>
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

	<div class="portfolio-slider">
		<div class="flexSlideshow flexslider">
			<ul class="slides">
				@foreach ($banner as $bn)
					<li><img src="{{ $bn->imagen }}" alt ="{{ $bn->titulo }}"/></li>
				@endforeach
			</ul>
		</div>
	</div>

	<!-- Main container start -->

	<section id="main-container">
		<div class="container">

			<!-- Services -->

			<div class="row">
				<div class="col-md-12 heading">
					<span class="title-icon classic pull-left"><i class="fa fa-comments"></i></span>
					<h2 class="title classic">Preguntas Frecuentes</h2>
				</div>
			</div>

			
			<div class="row">
				<div class="col-md-12 col-sm-12">
					@foreach ($pregunta as $p)
					<div class="faq-box col-md-6 col-sm-6" >
						<h4>Q. ¿{{ $p->pregunta }}?</h4>
						<h5>{{ $p->respuesta }}.</h5>
						<small>
							Área asignada: {{ $p->area }} <br>
							Contacto: {{ $p->contacto }}
						</small>
					</div>
					@endforeach
		          	
				</div><!-- End col-md-6 -->

			</div><!-- Content row  end -->

		</div><!--/ container end -->

	</section><!--/ Main container end -->
	
	<section class="call-to-action">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h3>Registrese para empezar con su cotización</h3>
					<a href="#" class="pull-right btn btn-primary white">REGISTRAR</a>
				</div>
			</div>
		</div>
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
							<a class="thumb-holder" data-rel="prettyPhoto" href="web/images/gallery/1.jpg">
								<img src="web/images/gallery/1.jpg" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="images/gallery/2.jpg">
								<img src="web/images/gallery/2.jpg" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="images/gallery/3.jpg">
								<img src="images/gallery/3.jpg" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="images/gallery/4.jpg">
								<img src="images/gallery/4.jpg" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="images/gallery/5.jpg">
								<img src="images/gallery/5.jpg" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="images/gallery/6.jpg">
								<img src="images/gallery/6.jpg" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="images/gallery/6.jpg">
								<img src="images/gallery/7.jpg" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="images/gallery/6.jpg">
								<img src="images/gallery/8.jpg" alt="">
							</a>
							<a class="thumb-holder" data-rel="prettyPhoto" href="images/gallery/6.jpg">
								<img src="images/gallery/9.jpg" alt="">
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